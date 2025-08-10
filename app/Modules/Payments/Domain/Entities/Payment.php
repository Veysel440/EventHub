<?php

namespace App\Modules\Payments\Domain\Entities;

use App\Modules\Ticketing\Domain\Entities\Registration;
use App\Shared\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use BelongsToTenant;

    public const STATUS_INITIATED = 'initiated';
    public const STATUS_SUCCEEDED = 'succeeded';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'tenant_id','registration_id','amount','currency','provider','provider_ref','status','meta'
    ];
    protected $casts = ['amount'=>'decimal:2','meta'=>'array'];

    public function registration(): BelongsTo { return $this->belongsTo(Registration::class); }
}
