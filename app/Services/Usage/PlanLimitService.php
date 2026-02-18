<?php

namespace App\Services\Usage;

use App\Enums\UsageTrackingMetric;
use App\Exceptions\PlanLimitExceededException;
use App\Models\Tenant;

class PlanLimitService
{
    public function __construct(private UsageService $usageService) {}

    public function ensureCanPerform(
        int $tenantId,
        UsageTrackingMetric $metric,
        int $requestedAmount = 1
    ): void {

        $limit = $this->getPlanLimit($tenantId, $metric);
//        dd($metric);
        // unlimited plan
        if ($limit === null || $limit < 0) {
            return;
        }



        $usage = $this->usageService->getCurrentUsage($tenantId, $metric);



        if (($usage + $requestedAmount) > $limit) {
            throw new PlanLimitExceededException($metric, $limit, $usage);
        }
    }

    public function getPlanLimit(int $tenantId, UsageTrackingMetric $metric): ?int
    {
        $tenant = Tenant::with('subscription.plan')->find($tenantId);


        if (!$tenant?->subscription?->plan) {
            return 0;
        }

        $plan = $tenant->subscription->plan;

        return $plan->getLimit($metric->limitKey());
    }
}
