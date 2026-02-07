<?php

namespace App\Repositories\Billing;

use App\Contracts\Repositories\Billing\PlanRepositoryInterface;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;

class PlanRepository implements PlanRepositoryInterface
{

    public function findBySlug(string $slug): Plan
    {
        return Plan::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function findById(int $id): Plan
    {
       return Plan::where('is_active', true)->findtOrFail($id);
    }

    public function getDefaultPlan(): Plan
    {
        return Plan::where('slug', 'free')->firstOrFail();
    }

    public function getAvailablePlans(): Collection
    {
        return Plan::where('is_active', true)->get();
    }
}
