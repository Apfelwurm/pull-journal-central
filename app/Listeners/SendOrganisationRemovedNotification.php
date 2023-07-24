<?php

namespace App\Listeners;

use App\Events\OrganisationRemoved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrganisationRemovedNotification
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
    public function handle(OrganisationRemoved $event): void
    {
        //
    }
}
