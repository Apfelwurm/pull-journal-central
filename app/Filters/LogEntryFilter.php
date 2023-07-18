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

    public function acknowledged(Builder $query, $acknowledged)
    {
        if ($acknowledged == 'true') {
            return $query->whereNotNull('acknowledged_at');
        }

        return $query;
    }
    
    public function notacknowledged(Builder $query, $notacknowledged)
    {
            if ($notacknowledged == 'true') {
            return $query->whereNull('acknowledged_at');
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
