<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Organisation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Role::class);
    }

}
