<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class InvitationPolicy
{

    public function invite(User $user): bool
    {
        return $user->hasAnyRole([
            Role::OWNER->value,
            Role::ADMIN->value,
        ], 'api', $user->current_tenant_id);
    }
}
