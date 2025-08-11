<?php

namespace App\Modules\Ticketing\Domain\Entities;

use App\Models\User;
use App\Modules\Events\Domain\Entities\Event;
use App\Shared\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registration extends Model
{
    use BelongsToTenant;

    public const STATUS_PENDING    = 'pending';
    public const STATUS_PAID       = 'paid';
    public const STATUS_CANCELLED  = 'cancelled';
    public const STATUS_CHECKED_IN = 'checked_in';

    protected $fillable = [
        'tenant_id','event_id','ticket_type_id','user_id','buyer_email','status','qr_code'
    ];

    protected $casts = [
        'created_at'=>'immutable_datetime',
        'updated_at'=>'immutable_datetime',
    ];

    // relations
    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function ticketType(): BelongsTo { return $this->belongsTo(\App\Modules\Ticketing\Domain\Entities\TicketType::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function payments(): HasMany { return $this->hasMany(\App\Modules\Payments\Domain\Entities\Payment::class); }

    public function scopePaid($q) { return $q->where('status', self::STATUS_PAID); }
    public function scopePending($q) { return $q->where('status', self::STATUS_PENDING); }

    public function markCheckedIn(): void
    {
        $this->status = self::STATUS_CHECKED_IN;
        $this->save();
    }
}
