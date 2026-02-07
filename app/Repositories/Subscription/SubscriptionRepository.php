<?php

namespace App\Repositories\Subscription;

use App\Contracts\Repositories\Billing\SubscriptionRepositoryInterface;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Repositories\BaseRepository;

class SubscriptionRepository extends BaseRepository implements SubscriptionRepositoryInterface
{
    public function __construct(Subscription $subscription)
    {
        parent::__construct($subscription);
    }



    public function findActiveForTenant(int $tenantId): ?\App\Models\Subscription
    {
        return $this->model
            ->where('tenant_id', $tenantId)
            ->whereIn('stripe_status', [
                \App\Enums\StripeStatus::ACTIVE,
                \App\Enums\StripeStatus::PAST_DUE,
            ])
            ->first();
    }

    public function createTrial(Tenant $tenant,Plan $plan): Subscription
    {
        return $this->create([
            'tenant_id' => $tenant->id,
            'plan_id' => $plan->id,
            'stripe_status' => \App\Enums\StripeStatus::INCOMPLETE,
            'current_period_start' => now(),
            'current_period_end' => now()->addDays(14),
        ]);
    }
}
