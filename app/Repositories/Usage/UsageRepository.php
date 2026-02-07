<?php

namespace App\Repositories\Usage;

use App\Contracts\Repositories\Usage\UsageRepositoryInterface;
use App\Enums\UsageTrackingMetric;
use App\Models\Tenant;


class UsageRepository implements UsageRepositoryInterface
{
    public function initializeForTenant(Tenant $tenant): void
    {
        $now = now();
        foreach (UsageTrackingMetric::cases() as $metric) {
            \App\Models\UsageTracking::create([
                'tenant_id' => $tenant->id,
                'metric' => $metric,
                'year' => $now->year,
                'month' => $now->month,
                'day' => $now->day,
                'value' => 0,
            ]);
        }
    }

    public function increment(Tenant $tenant, string $metric, int $amount = 1): void
    {
        \App\Models\UsageTracking::where('tenant_id', $tenant->id)
            ->where('metric', $metric)
            ->where('period', now()->startOfMonth())
            ->increment('value', $amount);
    }
}
