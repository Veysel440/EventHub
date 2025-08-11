<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Tenant extends Model
{
    protected $fillable = ['name','slug','status'];
    protected $casts = ['created_at'=>'immutable_datetime','updated_at'=>'immutable_datetime'];

    protected static function booted(): void
    {
        static::creating(function (self $m) {
            if (empty($m->slug) && !empty($m->name)) {
                $m->slug = Str::slug($m->name).'-'.Str::random(6);
            }
            if (empty($m->status)) $m->status = 'active';
        });
    }

    public function users(): HasMany { return $this->hasMany(User::class); }

    public function venues(): HasMany { return $this->hasMany(\App\Modules\Events\Domain\Entities\Venue::class); }
    public function events(): HasMany { return $this->hasMany(\App\Modules\Events\Domain\Entities\Event::class); }
}
