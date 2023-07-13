<?php

namespace App\Models\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class DeviceOrganisationScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::hasUser() && (Auth::user()->isDeviceAdmin() || Auth::user()->isViewer() )) {
            $builder->where('organisation_id', '=', Auth::user()->organisation->id);
        }
    }
}
