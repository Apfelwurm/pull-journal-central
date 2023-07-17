<?php

namespace App\Listeners;

use App\Enums\UserRoleEnum;
use App\Events\LogEntryAknowledged;
use App\Events\LogEntryCreated;
use App\Notifications\LogEntryAknowledgedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Models\User;


class SendLogEntryAknowledgedNotification
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
    public function handle(LogEntryAknowledged $event): void
    {

    }
}
