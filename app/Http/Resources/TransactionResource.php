<?php

namespace App\Http\Resources;

use App\Enums\TicketType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'user' => $this->user->name,
            'memberId' => $this->user->member_id,
            'category' => $this->type,
            'ticket' => $this->ticket->name ?? 'N/A',
            'eventTicketType' => $this->event_ticket_type ?? 'N/A',
            "amount" => $this->amount,
            "numberOfTickets" => $this->number_of_tickets ?? 'N/A',
            "status" => $this->status,
            'paymentMethod' => $this->payment_method,
            'reference' => $this->reference,
            'remarks' => $this->remark,
            "createdAt" => $this->created_at->format('d/m/y h:i A'),
        ];
    }
}
