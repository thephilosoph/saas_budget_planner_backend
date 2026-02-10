<?php

namespace App\Providers;

use App\Contracts\Repositories\Core\BudgetRepositoryInterface;
use App\Contracts\Repositories\Core\CategoryRepositoryInterface;
use App\Contracts\Services\Core\BudgetServiceInterface;
use App\Contracts\Services\Core\CategoryServiceInterface;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Policies\BudgetPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\TransactionPolicy;
use App\Repositories\Core\BudgetRepository;
use App\Repositories\Core\CategoryRepository;
use App\Services\Core\BudgetService;
use App\Services\Core\CategoryService;
use Illuminate\Support\Facades\Gate;
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

        $this->app->bind(
            \App\Contracts\Repositories\Finance\TransactionRepositoryInterface::class,
            \App\Repositories\Finance\TransactionRepository::class
        );
        $this->app->bind(
            \App\Contracts\Services\Finance\TransactionServiceInterface::class,
            \App\Services\Finance\TransactionService::class
        );

        $this->app->bind(BudgetRepositoryInterface::class, BudgetRepository::class);
        $this->app->bind(BudgetServiceInterface::class, BudgetService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Budget::class, BudgetPolicy::class);
        Gate::policy(Transaction::class, TransactionPolicy::class);

    }
}
