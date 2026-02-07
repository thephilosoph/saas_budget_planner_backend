<?php

namespace App\Providers;

use App\Contracts\Repositories\Authentication\AuthRepositoryInterface;
use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Repositories\Auth\AuthRepository;
use App\Services\Auth\AuthService;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(now()->addMinutes(30));
        Passport::refreshTokensExpireIn(now()->addDays(14));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
