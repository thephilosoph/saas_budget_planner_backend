<?php

namespace App\Providers;

use App\Contracts\Repositories\Core\CategoryRepositoryInterface;
use App\Contracts\Services\Core\CategoryServiceInterface;
use App\Repositories\Core\CategoryRepository;
use App\Services\Core\CategoryService;
use Illuminate\Support\ServiceProvider;

class CoreProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
