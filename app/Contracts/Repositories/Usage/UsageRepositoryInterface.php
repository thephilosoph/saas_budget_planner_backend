<?php

namespace App\Contracts\Repositories\Usage;

use App\Models\Tenant;

interface UsageRepositoryInterface
{
    public function initializeForTenant(Tenant $tenant): void;

    public function increment(
        Tenant $tenant,
        string $metric,
        int $amount = 1
    ): void;
}
