<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\User;

class BudgetPolicy extends BasePolicy
{


    public function view(User $user, Budget $budget): bool
    {
        return $this->belongsToTenant($user, $budget)
            && $this->hasTenantPermission($user, 'tenant:budgets.view');
    }

    public function create(User $user): bool
    {
        return $this->hasTenantPermission($user, 'tenant:budgets.create');
    }

    public function update(User $user, Budget $budget): bool
    {
        return $this->belongsToTenant($user, $budget)
            && $this->hasTenantPermission($user, 'tenant:budgets.update');
    }

    public function delete(User $user, Budget $budget): bool
    {
        return $this->belongsToTenant($user, $budget)
            && $this->hasTenantPermission($user, 'tenant:budgets.delete');
    }
}
