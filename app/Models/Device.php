<?php

namespace App\Models;

use App\Models\Scopes\DeviceOrganisationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Device extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'deviceidentifier',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'verified_at' => 'datetime',
        'last_api_call' => 'datetime',
        // 'verified_from' => User::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new DeviceOrganisationScope);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function verifiedfrom()
    {
        return $this->belongsTo(User::class, 'verified_from', 'id');
    }
}
