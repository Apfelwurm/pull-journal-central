<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class LogEntryFilter
{
    public function id(Builder $query, $id)
    {
        if ($id) {
            return $query->where('id', 'like', $id);
        }

        return $query;
    }

    public function source(Builder $query, $source)
    {
        if ($source) {
            return $query->where('source', 'like', $source);
        }

        return $query;
    }

    public function class(Builder $query, $class)
    {
        if ($class) {
            return $query->where('class', 'like', $class);
        }

        return $query;
    }

    public function aknowledged(Builder $query, $acknowledged)
    {
        if ($acknowledged == 'true') {
            return $query->whereNotNull('aknowledged_at');
        }

        return $query;
    }
    
    public function notaknowledged(Builder $query, $notacknowledged)
    {
            if ($notacknowledged == 'true') {
            return $query->whereNull('aknowledged_at');
        }

        return $query;
    }

    public function device(Builder $query, $device)
    {
        if ($device) {
            return  $query->where(function ($query) use ($device) {
                $query->whereRelation('device', 'name', 'like', $device)
                      ->orWhereRelation('device', 'deviceidentifier', 'like', $device)
                      ->orWhereRelation('device', 'id', '=', $device);
            });
        }

        return $query;
    }

}
