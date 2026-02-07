<?php

namespace App\Contracts\Repositories\Billing;

use App\Contracts\Repositories\BaseRepositoryInterface;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;

interface SubscriptionRepositoryInterface extends BaseRepositoryInterface
{
    public function createTrial(Tenant $tenant, Plan $plan): Subscription;
    public function findActiveForTenant(int $tenantId): ?Subscription;
}
