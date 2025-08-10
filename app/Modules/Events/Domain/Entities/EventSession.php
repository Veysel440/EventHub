<?php

namespace App\Modules\Events\Domain\Entities;

use App\Shared\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSession extends Model
{
    use BelongsToTenant;
    protected $fillable = ['tenant_id','event_id','title','starts_at','ends_at'];
    protected $casts = ['starts_at'=>'immutable_datetime','ends_at'=>'immutable_datetime'];

    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
}
