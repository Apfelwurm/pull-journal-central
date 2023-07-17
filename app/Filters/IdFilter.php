<?php

namespace App\Filters;

class IdFilter
{
    function __invoke($query, $id)
    {
        return $query->whereHas('id', function ($query) use ($id) {
            $query->where('id', $id);
        });
    }
}