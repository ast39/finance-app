<?php

namespace App\Providers;

use App\Models\Credit\Credit;
use App\Models\Credit\CreditPayment;
use App\Models\Spend\Spend;
use App\Observers\CreditObserver;
use App\Observers\CreditPaymentObserver;
use App\Observers\SpendObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Spend::observe(SpendObserver::class);
        Credit::observe(CreditObserver::class);
        CreditPayment::observe(CreditPaymentObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
