<?php

namespace App\Models;

use App\Traits\Auditable;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    use Auditable;

    protected $guarded = ['id',
        'stripe_subscription_id',
        'trial_ends_at','current_period_start','current_period_end','canceled_at'];
    protected $casts = [
        'stripe_status' => \App\Enums\StripeStatus::class,
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
    protected $hidden = ['stripe_subscription_id'];

    public function isActive(): bool
    {
        return $this->valid();
    }

    public function shouldAudit(string $action): bool
    {
        return in_array($action, ['created', 'updated', 'deleted']);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
