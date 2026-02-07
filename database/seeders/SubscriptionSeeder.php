<?php

namespace Database\Seeders;

use App\Enums\StripeStatus;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();
        $plan = Plan::where('name', 'free')->first();

        Subscription::create([
            'tenant_id' => $tenant->id,
            'plan_id' => $plan->id,
            'stripe_status' => StripeStatus::ACTIVE,
            'current_period_start' => now(),
            'current_period_end' => now()->addMonth(),
        ]);
    }
}
