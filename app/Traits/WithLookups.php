<?php

namespace App\Traits;

trait WithLookups {

    public static function all(): array
    {
        return self::cases();
    }

    public static function fromNames( mixed $statuses ): array
    {
        return collect(Arr::wrap($statuses))
            ->transform(fn($status, $name) => constant("self::$name")->value)
            ->toArray();
    }
}
