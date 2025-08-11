<?php

namespace App\Modules\Ticketing\Domain\Entities;

use App\Shared\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class CheckInLog extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id','registration_id','user_id','ip','user_agent','device','checked_in_at'
    ];

    protected $casts = [
        'checked_in_at' => 'immutable_datetime',
    ];
}
