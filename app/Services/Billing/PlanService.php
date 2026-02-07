<?php

namespace App\Services\Billing;

use App\Contracts\Repositories\Billing\PlanRepositoryInterface;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;

class PlanService
{
    public function __construct(
        private PlanRepositoryInterface $plans
    ) {}

    public function getAvailablePlans(): Collection
    {
        return $plans = $this->plans->getAvailablePlans();
    }

    public function canUseFeature(Plan $plan, string $feature): bool
    {
        return data_get($plan->features, $feature) === true;
    }

    public function getLimit(Plan $plan, string $feature): ?int
    {
        return data_get($plan->features, $feature);
    }
}
