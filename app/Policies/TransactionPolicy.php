<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy extends BasePolicy
{
    public function view(User $user, Transaction $transaction): bool
    {
        return $this->belongsToTenant($user, $transaction)
            && $this->hasTenantPermission($user, 'tenant:transaction.view');
    }

    public function create(User $user): bool
    {
        return $this->hasTenantPermission($user, 'tenant:transaction.create');
    }

    public function update(User $user, Transaction $transaction): bool
    {
        return $this->belongsToTenant($user, $transaction)
            && $this->hasTenantPermission($user, 'tenant:transaction.update');
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        return $this->belongsToTenant($user, $transaction)
            && $this->hasTenantPermission($user, 'tenant:transaction.delete');
    }
}
