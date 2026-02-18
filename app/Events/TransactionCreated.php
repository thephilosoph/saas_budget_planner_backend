<?php

namespace App\Events;

use App\Contracts\Usage\ShouldTrackUsage;
use App\Enums\UsageTrackingMetric;
use App\Models\Transaction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionCreated implements ShouldTrackUsage
{
    use Dispatchable, SerializesModels;

    public function __construct(public Transaction $transaction) {}

    public function usageMetric(): UsageTrackingMetric
    {
        return UsageTrackingMetric::TRANSACTIONS_COUNT;
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
