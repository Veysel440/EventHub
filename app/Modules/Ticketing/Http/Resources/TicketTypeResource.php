<?php

namespace App\Modules\Ticketing\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketTypeResource extends JsonResource
{
    public function toArray($req): array
    {
        return [
            'id'=>$this->id,
            'event_id'=>$this->event_id,
            'name'=>$this->name,
            'stock'=>$this->stock,
            'price'=>$this->price,
            'currency'=>$this->currency,
        ];
    }
}
