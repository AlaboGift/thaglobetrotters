<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            'url' => $this->getURL(),
            'isDefault' => $this->is_default,
            'imageType' => $this->image_type,
            "createdAt" => $this->created_at->format('d M Y h:i A'),
        ];
    }
}
