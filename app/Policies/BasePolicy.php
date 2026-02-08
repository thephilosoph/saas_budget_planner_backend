<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

abstract class BasePolicy
{
    protected function belongsToTenant(User $user, Model $model): bool
    {
        return (int) $model->tenant_id === (int) $user->current_tenant_id;
    }

    protected function hasTenantPermission(User $user, string $permission): bool
    {
        if (!$user->current_tenant_id) {
            return false;
        }

        return $user->hasPermissionTo(
            $permission,
            'api',
            $user->current_tenant_id
        );
    }

    protected function hasPlatformPermission(User $user, string $permission): bool
    {
        return $user->hasPermissionTo($permission, 'api');
    }

    protected function isOwner(User $user): bool
    {
        return $user->hasRole(
            \App\Enums\Role::OWNER->value,
            'api',
            $user->current_tenant_id
        );
    }
}
