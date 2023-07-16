<?php

namespace App\Listeners;

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
        Notification::sendNow(User::where("id",1)->first(),new LogEntryCreatedNotification($event->logEntry));
    }
}
