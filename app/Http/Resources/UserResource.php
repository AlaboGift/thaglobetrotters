<?php

namespace App\Http\Resources;

use App\Enums\UserRole;
use App\Models\General\Country;
use App\Models\General\State;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'age' => $this->age,
            'fullName' => $this->getName(),
            'memberId' => $this->member_id,
            'profilePhotoUrl' => $this->profile_photo_url,
            'status' => $this->status,
            'email' => $this->email,
            'phone' => $this->phone_number,
            'address' => $this->address,
            'isGuestUser' => $this->is_guest,
            'userType' => $this->is_guest ? 'GUEST' : 'RETURNING',
            'walletBalance' => $this->wallet->balance ?? 0,
            'totalEarning' => $this->transactions()->earnings()->sum('amount') ?? 0,
            'hasVerifiedEmail' => $this->email_verified_at ? true : false,
            'onboardedAt' => $this->created_at,
            'roles' => $this->roles()->pluck('name'),
            'resources' => $this->permissions()->pluck('name'),
            'location' => new StateResource($this->state ?? State::find(State::DEFAULT)),
            'country' => new CountryResource($this->country ?? Country::find(Country::DEFAULT)),
        ];

        if($this->role == UserRole::CUSTOMER){
            $data["signedWaiver"] =  $this->waivers()->count() ? true : false;
            $data['waiverExpiryDate'] = $this->waivers()?->first()?->expires_at;
        }

        return $data;
    }
}