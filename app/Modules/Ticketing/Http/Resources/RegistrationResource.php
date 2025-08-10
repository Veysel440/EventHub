<?php

namespace App\Modules\Ticketing\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Ticketing\Http\Resources\TicketTypeResource;

class RegistrationResource extends JsonResource
{
    public function toArray($req): array
    {
        return [
            'id'=>$this->id,
            'buyer_email'=>$this->buyer_email,
            'status'=>$this->status,
            'qr_code'=>$this->qr_code,
            'ticket_type'=>new TicketTypeResource($this->whenLoaded('ticketType')),
        ];
    }
}
