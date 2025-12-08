<?php

namespace App\Services;

use App\Enums\Status;
use App\Http\Resources\UserResource;
use App\Models\General\Country;
use App\Models\General\State;
use App\Models\Ticket;
use App\Models\User;
use App\Enums\UserRole;
use App\Services\Messaging\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, DB, RateLimiter};
use App\Utils\Utils;
use Exception;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;

class AuthService
{
   public function login($params)
   {
        $user = User::where('email', $params['username'])
            ->orWhere('member_id', $params['username'])->first();

        if (!$user) {
            RateLimiter::hit($this->throttleKey($params));
            throw new Exception('Invalid credentials entered');
        }

        if ($user['status'] != Status::ACTIVE) {
            throw new Exception('Your Account has been deactivated, please contact the admin for support');
        }

        if (!Hash::check($params['password'], $user['password'])) {
            RateLimiter::hit($this->throttleKey($params));
            throw new Exception('Invalid credentials entered');
        }

        $apiToken = $user->createToken(config('app.name'))->plainTextToken;
        $user->last_login = now();
        $user->save();

        $user->roles = $user->getRoleNames();
        RateLimiter::clear($this->throttleKey($params));

        $data = ['user' => new UserResource($user), 'token' => $apiToken];

        return $data;
   }

   public function throttleKey(Request $params)
   {
       return \Str::lower($params->input('username')) . '|' . $params->ip();
   }

   public function createGuestUser($email, $name, $age)
    {
        // Validate input parameters
        if (empty($email) || empty($name) || empty($age)) {
            throw new Exception("Invalid details for guest checkout");
        }

        // Check if the user exists, including soft-deleted users
        $user = User::withTrashed()->firstWhere('email', $email);
        $isNewUser = !$user;

        $user = $user ?? new User();
        $user->is_guest = $isNewUser;
        $user->name = $name;
        $user->email = $user->email ?? $email;
        $user->age = $age;
        $user->member_id = $user->member_id ?? Utils::generateMemberID();
        $user->password = $user->password ?? Hash::make(\Str::random(8));
        $user->state_id = $user->state_id ?? State::DEFAULT;
        $user->country_id = $user->country_id ?? Country::DEFAULT;
        $user->deleted_at = null;
        $user->reason_for_delete = null;
        $user->save();

        // Assign role and create wallet for new users
        if ($isNewUser) {
            $user->assignRole(UserRole::CUSTOMER);
            $user->wallet()->create(['balance' => 0]);
        }

        return $user;
    }

   public function register($params)
   {
        DB::beginTransaction();

        try{

            $expiresAt = now()->addYears(2);
            $user = User::withTrashed()->firstWhere('email', $params['email']) ?? new User();
            $user->name = $params['name'];
            $user->email = $params['email'];
            $user->member_id ??= Utils::generateMemberID();
            $user->password = Hash::make($params['password']);
            $user->age = $params['age'];
            $user->state_id = $params['location'];
            $user->country_id = Country::DEFAULT;
            $user->deleted_at = null;
            $user->reason_for_delete = null;
            $user->save();

            $user->assignRole(UserRole::CUSTOMER);
            $user->waivers()->create(['expires_at' => $expiresAt]);
            $user->wallet()->create(['balance' => 0]);

            DB::commit();

            $apiToken = $user->createToken(config('app.name'))->plainTextToken;

            $data = [
                'user' => new UserResource($user), 
                'token' => $apiToken,
                'message' => "Dear User, your account has been successfully created and your waiver would end on ".$expiresAt->format("d/m/Y")
            ];

            return $data;

        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
   }

   public function logout(User $user)
   {
       $user->currentAccessToken()->delete();
       return true;
   }

   public function changePassword(User $user, array $request)
   {

       if (!Hash::check($request['oldPassword'], $user->password)) {
           throw new Exception(__("Password doesn't match old password"));
       }

       $user->password = Hash::make($request['newPassword']);
       $user->save();

       return $user;
   }

   public function updateProfile($user, $params)
   {
        $user->age = $params->age;
        $user->state_id = $params->location;
        $user->name = $params->name;
        $user->save();

        return $user;
   }

   public function resetPassword(User $user, array $request)
   {
       if ($user->reset_token_expires_at < now()) {
           throw new Exception('Token has expired');
       }

       $user->reset_token = Null;
       $user->reset_token_expires_at = Null;
       $user->password = Hash::make($request['newPassword']);
       $user->save();

       return $user;
   }

   public function countries()
   {
       return Country::orderByRaw("id = ? DESC, country ASC", [Country::DEFAULT])->get();
   }

   public function states()
   {
       return State::where('country_id', Country::DEFAULT)->orderByRaw("id = ? DESC, state ASC", [State::DEFAULT])->get();
   }

   public function verifyEmail(array $request)
   {
       $user = auth()->user();

       if (!$user->email_verification_code) {
           throw new Exception('Invalid Token');
       }

       if ($user->email_verification_code_expires_at < now()) {
           throw new Exception('Token has expired');
       }

       $user->email_verification_code = Null;
       $user->email_verification_code_expires_at = Null;
       $user->email_verified_at = now();
       $user->save();

       return $user;
   }

   public function resendVerificationCode(User $user)
   {
       try {

           DB::beginTransaction();
           $user->email_verification_code = random_int(1000, 9999);
           $user->email_verification_code_expires_at = now()->addHour();
           $user->save();
   
           (new EmailService("emails.otp", $user->email, "Upbeat Verification", ['user' => $user]))->dispatch();

           DB::commit();
       } catch (Exception $e) {
           DB::rollBack();
           throw new Exception($e->getMessage());
       }
   }

   public function forgotPassword(string $email)
   {
       try {
           $user = User::firstWhere(['email' => $email]);

           if (!$user) {
               return false;
           }

           $token = Utils::unique('users', 'reset_token', 4, 'int');
           $tokenExpires = now()->addHour();
           $user->reset_token = $token;
           $user->reset_token_expires_at = $tokenExpires;
           $user->save();

           (new EmailService("emails.reset-password", $user->email, "Password Reset", ['user' => $user, 'token' => $token]))->dispatch();

           return true;
       } catch (\Throwable $th) {
           throw $th;
       }
   }

   public function roles()
   {
        return Role::where('name', '!=', UserRole::CUSTOMER)->get()->map(function($role){
            return [
                'id' => $role->id,
                'name' => Utils::cleanEnum($role->name)
            ];
        });
   }

   public function getEnumValuesFromDirectory()
   {
       $enums = [];
       $directory = app_path('Enums');
       $phpFiles = File::files($directory);

       foreach ($phpFiles as $phpFile) {
           $class = pathinfo($phpFile, PATHINFO_FILENAME);
           $className = 'App\Enums\\' . $class;
           $values = [];
           foreach ($className::getValues() as $value) {
               $values[] = [
                   'name' => $className::getDescription($value),
                   'value' => $value,
               ];
           }

           array_push($enums, ['enum' => $class, 'data' => $values]);
       }

       return $enums;
   }

   public function resources()
   {
        return Permission::get()->map(function($role){
            return [
                'id' => $role->id,
                'name' => Utils::cleanEnum($role->name)
            ];
        });
   }

   public function deleteAccount(array $params)
   {
       $user = User::where('email', $params['email'])->first();

        if(!$user->hasRole(UserRole::CUSTOMER)){
            throw new Exception("Invalid Account Type");
        }

       if (!Hash::check($params['password'], $user->password)) {
            throw new Exception(__("Invalid Credentials"));
       }

       return $user->update(['deleted_at' => now(), 'reason_for_delete' => $params['reason']]);
   }

   public function signWaiver($user, $hasChildren, $children = [], $ticketId = null)
   {
       $hasSignedWaiver = $user->waivers()->exists();
       $waiverRequiresChildren = $hasChildren && !empty($children);

       if($waiverRequiresChildren && $ticketId){
            $event = Ticket::find($ticketId);

            foreach ($children as $child) {
 
                $age = \Carbon\Carbon::parse($child['dob'])->age;
            
                if (!is_null($event->age_limit) && $age < $event->age_limit) {
                    throw new Exception("One or more children are under the minimum age limit of {$event->age_limit}");
                }
            
                if (!is_null($event->max_age_limit) && $age > $event->max_age_limit) {
                    throw new Exception("One or more children are above the maximum age limit of {$event->max_age_limit}");
                }
            }
       }
   
       if (!$hasSignedWaiver || ($hasSignedWaiver && $waiverRequiresChildren)) {

           $expiresAt = now()->addYears(2);
           $user->waivers()->create(['expires_at' => $expiresAt, 'children' => $waiverRequiresChildren ? json_encode($children) : null]);
           return true;

       }

       return true;
   }
}