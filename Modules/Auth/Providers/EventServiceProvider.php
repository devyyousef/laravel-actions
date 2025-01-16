<?php

namespace Modules\Auth\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Auth\Events\RegisterEvent;
use Modules\Auth\Events\ResendVerifyEmailEvent;
use Modules\Auth\Listeners\SendVerificationEmail;
use Modules\Auth\Listeners\SendWelcomeEmail;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        RegisterEvent::class => [
            SendWelcomeEmail::class,
            SendVerificationEmail::class,
        ],
        ResendVerifyEmailEvent::class => [
            SendVerificationEmail::class,
        ],
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void
    {
        //
    }
}
