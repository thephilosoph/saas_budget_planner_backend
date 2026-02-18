<?php

namespace App\Contracts\Usage;

use App\Enums\UsageTrackingMetric;

interface ShouldTrackUsage
{
    public function usageMetric(): UsageTrackingMetric;
    public function usageTenantId(): int;
    public function usageAmount(): int;
}
