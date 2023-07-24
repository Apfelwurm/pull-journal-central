<?php

namespace App\Listeners;

use App\Enums\UserRoleEnum;
use App\Events\LogEntryAcknowledged;
use App\Events\LogEntryCreated;
use App\Notifications\LogEntryAcknowledgedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Models\User;


class SendLogEntryAcknowledgedNotification
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
    public function handle(LogEntryAcknowledged $event): void
    {

    }
}
