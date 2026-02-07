<?php

namespace App\Providers;

use App\Contracts\Repositories\Authentication\TenantRepositoryInterface;
use App\Repositories\Auth\TenantRepository;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            TenantRepositoryInterface::class,
            TenantRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
