<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = is_array($this->data) ? (object)$this->data : json_decode($this->data);

        return [
            "id" => $this->id,
            "userId" => $this->notifiable_id,
            "subject" => $data->subject,
            "body" => $data->body,
            "isRead" => $this->read_at ? true : false,
            "readAt" => $this->read_at?->format('d M Y h:i A'),
            "createdAt" => $this->created_at->format('d M Y h:i A'),
        ];
    }
}
