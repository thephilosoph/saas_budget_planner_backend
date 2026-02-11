<?php

namespace App\Providers;

use App\Contracts\Repositories\Authentication\TenantInvitationRepositoryInterface;
use App\Contracts\Repositories\Authentication\TenantRepositoryInterface;
use App\Contracts\Services\Auth\TenantInvitationServiceInterface;
use App\Models\TenantInvitation;
use App\Policies\TenantInvitationPolicy;
use App\Repositories\Auth\TenantInvitationRepository;
use App\Repositories\Auth\TenantRepository;
use App\Services\Auth\TenantInvitationService;
use Illuminate\Support\Facades\Gate;
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
        $this->app->bind(
            TenantInvitationServiceInterface::class,
            TenantInvitationService::class
        );
        $this->app->bind(
            TenantInvitationRepositoryInterface::class,
            TenantInvitationRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
//        Gate::define(TenantInvitation::class, TenantInvitationPolicy::class);
        Gate::define('accept', [TenantInvitationPolicy::class, 'accept']);

    }
}
