<?php

namespace App\Listeners\Usage;

use App\Contracts\Usage\ShouldTrackUsage;
use App\Services\Usage\UsageService;

class TrackUsage
{
    public function __construct(private UsageService $usageService) {}

    public function handle(ShouldTrackUsage $event): void
    {
        $this->usageService->increment(
            $event->usageTenantId(),
            $event->usageMetric(),
            $event->usageAmount()
        );
    }
}
