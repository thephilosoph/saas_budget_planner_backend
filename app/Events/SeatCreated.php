<?php

namespace App\Events;


use App\Enums\UsageTrackingMetric;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SeatCreated
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
        return UsageTrackingMetric::SEATS_USED;
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
