<?php

namespace App\Providers;

use App\Contracts\Repositories\Billing\PlanRepositoryInterface;
use App\Contracts\Repositories\Billing\SubscriptionRepositoryInterface;
use App\Repositories\Billing\PlanRepository;
use App\Repositories\Subscription\SubscriptionRepository;
use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            PlanRepositoryInterface::class,
            PlanRepository::class
        );
        $this->app->bind(SubscriptionRepositoryInterface::class,
        SubscriptionRepository::class);

//        $this->app->bind(PlanS)
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
