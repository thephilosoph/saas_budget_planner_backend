<?php

namespace App\Contracts\Repositories\Billing;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;

interface PlanRepositoryInterface
{
    public function findBySlug(string $slug): Plan;
    public function findById(int $id): Plan;
    public function getDefaultPlan(): Plan;

    public function getAvailablePlans(): Collection;
}
