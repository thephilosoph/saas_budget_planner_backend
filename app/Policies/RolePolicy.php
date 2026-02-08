<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class RolePolicy extends BasePolicy
{
    public function assignRole(User $user, string $role): bool
    {
        if ($user->hasRole(Role::OWNER->value, 'api', $user->current_tenant_id)) {
            return true;
        }

        return $user->hasRole(Role::ADMIN->value, 'api', $user->current_tenant_id)
            && $role !== Role::OWNER->value;
    }
}
