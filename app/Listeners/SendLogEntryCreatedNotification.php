<?php

namespace App\Listeners;

use App\Enums\UserRoleEnum;
use App\Events\LogEntryCreated;
use App\Notifications\LogEntryCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Models\User;


class SendLogEntryCreatedNotification
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
    public function handle(LogEntryCreated $event): void
    {
        $superadmins = User::where("role", UserRoleEnum::SUPERADMIN)->get();
        $organisationusers = $event->logEntry->device->organisation->notificationUsers;

        $mergedusers = $superadmins->merge($organisationusers);
        Notification::send($mergedusers,new LogEntryCreatedNotification($event->logEntry));
    }
}
