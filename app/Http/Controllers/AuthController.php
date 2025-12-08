<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\UserRole;
use App\Mail\PasswordReset;
use App\Models\Cart;
use App\Models\General\Country;
use App\Models\General\Setting;
use App\Models\General\State;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\{Hash, DB};
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Toastr;
use Exception;
use Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register() {
        $title = 'Register';
        $settings = (object)Setting::pluck('value', 'key')->toArray();
        $states = $settings->site_country ? State::where('country_id', $settings->site_country)->get() : State::get();
        return view('auth.register', compact('title', 'states'));
    }

    public function postRegister(Request $request)
    {
        $data = $request->validate([
            "name" => 'required|string',
            "email" => 'required|email|unique:users,email',
            "password" => 'required|string',
            "confirm_password" => 'required|string|same:password'
        ]);

        DB::beginTransaction();

        try {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($data['confirm_password']);
            $user->state_id = State::DEFAULT;
            $user->country_id = Country::DEFAULT;
            $user->status = Status::ACTIVE;
            $user->ip = get_ip();
            $user->save();

            $user->assignRole(UserRole::CUSTOMER);
            DB::commit();

            Toastr::success('Registration Successful');
            return redirect('login');

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Registration failed, try again later : ' . $e->getMessage());
            Toastr::error('Registration failed, try again later');
            return redirect()->back();
        }
    }

    public function login() {
        $title = 'Login';
        $settings = (object)Setting::pluck('value', 'key')->toArray();
        return view('auth.login', compact('title', 'settings'));
    }

    public function postLogin(Request $request) {

        $this->validator($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        

        if(Auth::attempt(array('email' => $request->email, 'password' => $request->password), $request->filled('remember'))){
            $request->session()->regenerate();
            //Authentication passed...
            $user = $this->guard()->user();

            if($user->hasRole(UserRole::CUSTOMER)){

                Cart::where('ip', get_ip())->whereNull('user_id')
                        ->update(['user_id' => $user->id]);

                Wishlist::where('ip', get_ip())->whereNull('user_id')
                        ->update(['user_id' => $user->id]);
                        
                $location = "profile";
            }else{
                $location = "dashboard";
            }

            $user->update(['last_login' => now()]);
            $location = $request->where ?? $location;
            
            Toastr::success('Login Successful', 'Success');
            return redirect()->intended($location);
        } else {
            Toastr::error('The provided credentials do not match our records.', 'Failed');
            return back();
        }
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = app(RateLimiter::class)->availableIn(
            $this->throttleKey($request)
        );

        return back()->withError(trans('auth.throttle', ['seconds' => $seconds]));
    }

    private function validator(Request $request)
    {
        $rules = [
            'email'    => 'required',
            'password' => 'required',
        ];

        //validate the request.
        $request->validate($rules);
    }

        /**
     * Logout user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::user()->update(['last_login' => null]);
        Auth::logout();
        Toastr::success('Logout Success.', 'Success');
        return redirect()->route('login');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function forgot()
    {
        $title = 'Forgot Password';
        return view('auth.forgot', compact('title'));
    }

    public function postForgot(Request $request)
    {
        $data = $request->validate([
            "email" => 'required|email|exists:users,email',
        ]);

        DB::beginTransaction();

        try {

            $user = User::firstWhere(['email' => $request->email]);

            if (!$user) {
                Toastr::error("Invalid Email Provided");
                return redirect()->back();
            }

            $token = unique('users', 'reset_token', 4, 'int');
            $tokenExpires = now()->addHour();
            $user->reset_token = $token;
            $user->reset_token_expires_at = $tokenExpires;
            $user->save();

            Mail::to($user)->later(now()->addSeconds(3), new PasswordReset($user, $token));

            DB::commit();

            Toastr::success('Password Reset Token Sent Successfully', 'Success');
            return redirect('reset-password');
        } catch(Exception $e) {
            DB::rollBack();
            \Log::error('Registration failed, try again later : ' . $e->getMessage());
            Toastr::error('Password Reset Token failed');
            return back();
        }
    }

    public function resetPassword()
    {
        $title = 'Reset Password';
        return view('auth.reset-password', compact('title'));
    }

    public function postResetPassword(Request $request)
    {
        $data = $request->validate([
            "email" => 'required|email|exists:users,email',
            "token" => ['required', Rule::exists('users', 'reset_token')->where('email', $request->email)],
            "password" => 'required|string',
            "confirm_password" => 'required|string|same:password'
        ]);

        DB::beginTransaction();

        $user = User::firstWhere('email', $request->email);

        if ($user->reset_token_expires_at < now()) {
            Toastr::error('Password Reset Token has expired');
            return back();
        }

        try {
            $user->reset_token = Null;
            $user->reset_token_expires_at = Null;
            $user->password = Hash::make($data['confirm_password']);
            $user->save();

            Toastr::success('Password Changed Successfully, Login', 'Success');
            return redirect('login');
        } catch(Exception $e) {
            DB::rollBack();
            \Log::error('Password Reset failed, try again later : ' . $e->getMessage());
            Toastr::error('Password Reset Token failed');
            return back();
        }
    }
}


