<?php

namespace App\Shared\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::creating(function ($model) {
            if (app()->has('tenant_id') && empty($model->tenant_id)) {
                $model->tenant_id = app('tenant_id');
            }
        });

        static::addGlobalScope('tenant', function (Builder $q) {
            if (app()->has('tenant_id')) {
                $q->where($q->from.'.tenant_id', app('tenant_id'));
            }
        });
    }
}
