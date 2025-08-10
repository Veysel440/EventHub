<?php

namespace App\Modules\Events\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($req): array
    {
        return [
            'id'=>$this->id,
            'public_id'=>$this->public_id,
            'title'=>$this->title,
            'description'=>$this->description,
            'starts_at'=>$this->starts_at,
            'ends_at'=>$this->ends_at,
            'status'=>$this->status,
            'venue'=>$this->whenLoaded('venue', fn()=>[
                'id'=>$this->venue->id,
                'name'=>$this->venue->name,
                'city'=>$this->venue->city,
            ]),
            'sessions'=>EventSessionResource::collection($this->whenLoaded('sessions')),
            'ticket_types'=>\App\Modules\Ticketing\Http\Resources\TicketTypeResource::collection(
                $this->whenLoaded('ticketTypes')
            ),
        ];
    }
}
