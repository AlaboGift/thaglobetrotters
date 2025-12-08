<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "description" => $this->description,
            "ageLimit" => $this->age_limit,
            "maxAgeLimit" => $this->max_age_limit,
            "hasParticipantCount" => $this->has_participant_count ? true : false,
            "minParticipants" => $this->min_participants,
            "maxParticipants" => $this->max_participants,
            "category" =>  $this->category,
            "location" =>  $this->location,
            "price" => $this->price,
            "count" => $this->count,
            "image" => $this->getImage() ? $this->getImage()->getURL() : null,
            "images" => ImageResource::collection($this->images()->get()),
            "availableTimes" => $this->ticket_times,
            "cashback" => $this->getCashBack(),
            "createdAt" => $this->created_at->format('d/m/y h:i A'),
        ];
    }
}
