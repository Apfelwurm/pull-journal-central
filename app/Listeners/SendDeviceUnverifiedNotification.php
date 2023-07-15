<?php

namespace App\Listeners;

use App\Events\DeviceUnverified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDeviceUnverifiedNotification
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
    public function handle(DeviceUnverified $event): void
    {
        //
    }
}
