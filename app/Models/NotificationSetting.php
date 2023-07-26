<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\NotificationProvicerEnum;


class NotificationSetting extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'enable_notifications',
        'enable_provider_mail',
        'enable_provider_ntfy',
        'ntfy_channel_id',
        'enable_log_entry_created_notification',
        'enable_device_created_notification',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enable_notifications' => 'boolean',
        'enable_provider_mail' => 'boolean',
        'enable_provider_ntfy' => 'boolean',
        'enable_log_entry_created_notification' => 'boolean',
        'enable_device_created_notification' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
