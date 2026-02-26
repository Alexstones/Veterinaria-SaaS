<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

trait Multitenant
{
    public static function bootMultitenant()
    {
        if (app()->bound('tenant')) {
            static::creating(function ($model) {
                if (!$model->tenant_id) {
                    $model->tenant_id = app('tenant')->id;
                }
            });

            static::addGlobalScope('tenant', function (Builder $builder) {
                $builder->where('tenant_id', app('tenant')->id);
            });
        }
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
