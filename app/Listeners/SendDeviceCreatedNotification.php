<?php

namespace App\Listeners;

use App\Events\DeviceCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DeviceCreatedNotification;


class SendDeviceCreatedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DeviceCreated $event): void
    {
        $superadmins = User::where("role", UserRoleEnum::SUPERADMIN)->get();
        $organisationusers = $event->device->organisation->notificationUsers;

        $mergedusers = $superadmins->merge($organisationusers);
        Notification::send($mergedusers,new DeviceCreatedNotification($event->device));
    }
}
