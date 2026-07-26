<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    // Model boot hote hi ye chal jayega
    protected static function bootBelongsToTenant()
    {
        // Sirf apne tenant ka data dikhao
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (Auth::check() && Auth::user()->tenant_id) {
                $builder->where(
                    (new static)->getTable() . '.tenant_id',
                    Auth::user()->tenant_id
                );
            }
        });

        // Create hote waqt tenant_id auto set karo
        static::creating(function ($model) {
            if (Auth::check() && !$model->tenant_id) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });
    }
}