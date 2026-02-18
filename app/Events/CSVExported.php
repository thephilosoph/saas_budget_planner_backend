<?php

namespace App\Events;

use App\Enums\UsageTrackingMetric;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CSVExported
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }

    public function usageMetric(): UsageTrackingMetric
    {
        return UsageTrackingMetric::EXPORTS_COUNT;
    }

    public function usageTenantId(): int
    {
        return $this->transaction->tenant_id;
    }

    public function usageAmount(): int
    {
        return 1;
    }
}
