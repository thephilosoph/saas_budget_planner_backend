<?php

namespace App\Providers;

use App\Contracts\Repositories\Authentication\AuthRepositoryInterface;
use App\Contracts\Repositories\Authentication\UserRepositoryInterface;
use App\Contracts\Repositories\Authorization\RoleRepositoryInterface;
use App\Contracts\Repositories\Usage\UsageRepositoryInterface;
use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\UserRepository;
use App\Repositories\Authorization\RoleRepository;
use App\Repositories\Usage\UsageRepository;
use App\Services\Auth\AuthService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
