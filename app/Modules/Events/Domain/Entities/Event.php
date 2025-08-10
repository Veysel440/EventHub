<?php

namespace App\Modules\Events\Domain\Entities;

use App\Modules\Ticketing\Domain\Entities\TicketType;
use App\Shared\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use BelongsToTenant;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'tenant_id','venue_id','public_id','title','description','starts_at','ends_at','status'
    ];
    protected $casts = ['starts_at'=>'immutable_datetime','ends_at'=>'immutable_datetime'];

    public function venue(): BelongsTo { return $this->belongsTo(Venue::class); }
    public function sessions(): HasMany { return $this->hasMany(EventSession::class); }
    public function ticketTypes(): HasMany { return $this->hasMany(TicketType::class); }
}
