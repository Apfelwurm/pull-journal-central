<?php

namespace App\Providers;

use App\Events\LogEntryCreated;
use App\Listeners\SendLogEntryCreatedNotification;
use Illuminate\Auth\Events\Registered;
use App\Events\DeviceCreated;
use App\Events\DeviceRemoved;
use App\Events\DeviceUnverified;
use App\Events\DeviceVerified;
use App\Events\DeviceUpdated;
use App\Listeners\SendDeviceCreatedNotification;
use App\Listeners\SendDeviceRemovedNotification;
use App\Listeners\SendDeviceUnverifiedNotification;
use App\Listeners\SendDeviceVerifiedNotification;
use App\Listeners\SendDeviceUpdatedNotification;

use App\Events\OrganisationCreated;
use App\Events\OrganisationRemoved;
use App\Events\OrganisationUpdated;
use App\Listeners\SendOrganisationCreatedNotification;
use App\Listeners\SendOrganisationRemovedNotification;
use App\Listeners\SendOrganisationUpdatedNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        DeviceCreated::class =>[
            SendDeviceCreatedNotification::class,
        ],
        DeviceRemoved::class => [
            SendDeviceRemovedNotification::class,
        ],
        DeviceVerified::class => [
            SendDeviceVerifiedNotification::class,
        ],
        DeviceUnverified::class => [
            SendDeviceUnverifiedNotification::class,
        ],
        DeviceUpdated::class => [
            SendDeviceUpdatedNotification::class,
        ],
        OrganisationCreated::class => [
            SendOrganisationCreatedNotification::class,
        ],
        OrganisationRemoved::class => [
            SendOrganisationRemovedNotification::class,
        ],
        OrganisationUpdated::class => [
            SendOrganisationUpdatedNotification::class,
        ],
        LogEntryCreated::class => [
            SendLogEntryCreatedNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
