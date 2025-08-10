<?php

namespace App\Modules\Events\Domain\Entities;

use App\Shared\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    use BelongsToTenant;
    protected $fillable = ['tenant_id','name','city','address','meta'];
    protected $casts = ['meta'=>'array'];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
