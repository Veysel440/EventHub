<?php

namespace App\Modules\Ticketing\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    public function toArray($req): array
    {
        return [
            'id'=>$this->id,
            'event_id'=>$this->event_id,
            'ticket_type_id'=>$this->ticket_type_id,
            'buyer_email'=>$this->buyer_email,
            'status'=>$this->status,
            'qr_code'=>$this->qr_code,
            'created_at'=>$this->created_at,
        ];
    }
}
