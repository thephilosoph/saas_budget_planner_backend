<?php

namespace App\Providers;

use App\Contracts\Repositories\Authentication\AuthRepositoryInterface;
use App\Contracts\Repositories\Authentication\AuthRepositoryPersonalAccessInterface;
use App\Contracts\Repositories\Authentication\PasswordResetRepositoryInterface;
use App\Contracts\Repositories\Authentication\TenantInvitationRepositoryInterface;
use App\Contracts\Repositories\Authentication\UserRepositoryInterface;
use App\Contracts\Repositories\Authorization\RoleRepositoryInterface;
use App\Contracts\Repositories\Usage\UsageRepositoryInterface;
use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Contracts\Services\Auth\TenantInvitationServiceInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\AuthRepositoryPersonalAccess;
use App\Repositories\Auth\PasswordResetRepository;
use App\Repositories\Auth\TenantInvitationRepository;
use App\Repositories\Auth\UserRepository;
use App\Repositories\Authorization\RoleRepository;
use App\Repositories\Usage\UsageRepository;
use App\Services\Auth\AuthService;
use App\Services\Auth\TenantInvitationService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthRepositoryPersonalAccessInterface::class,
            AuthRepositoryPersonalAccess::class
        );
        $this->app->bind(
            AuthRepositoryInterface::class,
            AuthRepository::class
        );
        $this->app->bind(UserRepositoryInterface::class,
        UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class,
        RoleRepository::class);
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );
        $this->app->bind(UsageRepositoryInterface::class,UsageRepository::class);

        $this->app->bind(TenantInvitationRepositoryInterface::class,TenantInvitationRepository::class);
        $this->app->bind(TenantInvitationServiceInterface::class,TenantInvitationService::class);

        $this->app->bind(PasswordResetRepositoryInterface::class,PasswordResetRepository::class);
//        $this->app->bind();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
