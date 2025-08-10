<?php

namespace App\Modules\Ticketing\Domain\Entities;

use App\Modules\Events\Domain\Entities\Event;
use App\Shared\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use BelongsToTenant;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_CHECKED_IN = 'checked_in';

    protected $fillable = [
        'tenant_id','event_id','ticket_type_id','user_id','buyer_email','status','qr_code'
    ];

    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function ticketType(): BelongsTo { return $this->belongsTo(TicketType::class); }
}
