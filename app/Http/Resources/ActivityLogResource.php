<?php

namespace App\Http\Resources;

use App\Utils\Constants;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user" => $this->user ? $this->user->getName() : 'N/A',
            "email" => $this->user ? $this->user->email : 'N/A',
            "phone_number" => $this->user ? $this->user->phone_number : 'N/A',
            "role" => $this->user ? $this->user->role : 'N/A',
            "contentType" => $this->content_type,
            "action" => $this->action,
            "description" => $this->description,
            "details" => $this->details,
            "ipAddress" => $this->ip_address,
            "userAgent" => $this->user_agent,
            "createdAt" => $this->created_at->format('d/m/y h:i A'),
        ];
    }
}
