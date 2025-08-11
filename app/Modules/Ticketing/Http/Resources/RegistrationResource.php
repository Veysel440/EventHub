<?php

namespace App\Modules\Ticketing\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    public function toArray($req): array
    {
        return [
            'id'=>$this->id,
            'buyer_email'=>$this->buyer_email,
            'status'=>$this->status,
            'qr_code'=>$this->qr_code,
            'ticket_type'=>$this->whenLoaded('ticketType', fn()=>[
                'id'=>$this->ticketType->id,
                'name'=>$this->ticketType->name,
                'price'=>$this->ticketType->price,
                'currency'=>$this->ticketType->currency,
            ]),
            'event'=>$this->whenLoaded('event', fn()=>[
                'id'=>$this->event->id,
                'title'=>$this->event->title,
                'starts_at'=>$this->event->starts_at,
                'ends_at'=>$this->event->ends_at,
            ]),
            'created_at'=>$this->created_at,
        ];
    }
}
