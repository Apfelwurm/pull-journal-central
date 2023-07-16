<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organisation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function superAdmins(): HasMany
    {
        return $this->hasMany(User::class)->where('role', UserRoleEnum::SUPERADMIN);
    }

    public function deviceAdmins(): HasMany
    {
        return $this->hasMany(User::class)->where('role', UserRoleEnum::DEVICEADMIN);
    }

    public function viewers(): HasMany
    {
        return $this->hasMany(User::class)->where('role', UserRoleEnum::VIEWER);
    }

    public function notificationUsers(): HasMany
    {
        return $this->hasMany(User::class)->where('role', UserRoleEnum::VIEWER)
                ->orWhere('role', UserRoleEnum::DEVICEADMIN)
                ->orWhere('role', UserRoleEnum::SUPERADMIN);
    }


}
