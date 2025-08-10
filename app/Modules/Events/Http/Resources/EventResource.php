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
            'venue_id'=>$this->venue_id,
        ];
    }
}
