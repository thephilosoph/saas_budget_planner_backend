<?php

namespace App\Events;

use App\Enums\UsageTrackingMetric;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CSVImported
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
        return UsageTrackingMetric::CSV_IMPORTS;
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
