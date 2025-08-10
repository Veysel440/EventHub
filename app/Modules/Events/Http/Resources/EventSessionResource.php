<?php

namespace App\Modules\Events\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class EventSessionResource extends JsonResource
{
    public function toArray($req): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'starts_at'=>$this->starts_at,
            'ends_at'=>$this->ends_at,
        ];
    }
}
