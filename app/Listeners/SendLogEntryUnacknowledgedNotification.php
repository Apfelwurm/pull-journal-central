<?php

namespace App\Listeners;

use App\Enums\UserRoleEnum;
use App\Events\LogEntryCreated;
use App\Events\LogEntryUnacknowledged;
use App\Notifications\LogEntryAcknowledgedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Models\User;


class SendLogEntryUnacknowledgedNotification
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
    public function handle(LogEntryUnacknowledged $event): void
    {

    }
}
