<?php

namespace App\Modules\Ticketing\Domain\Entities;

use App\Modules\Events\Domain\Entities\Event;
use App\Shared\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketType extends Model
{
    use BelongsToTenant;
    protected $fillable = ['tenant_id','event_id','name','stock','price','currency'];
    protected $casts = ['price'=>'decimal:2','stock'=>'integer'];

    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function registrations(): HasMany { return $this->hasMany(Registration::class); }
}
