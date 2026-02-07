<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

abstract class BasePolicy
{
//    protected function belongsToTenant(User $user, Model $model): bool
//    {
//        return $model->tenant_id === $user->current_tenant_id;
//    }
//
//    protected function hasTenantPermission(User $user, string $permission): bool
//    {
//        return $user->tenantRole()
//                ?->permissions
//            && in_array($permission, $user->tenantRole()->permissions, true);
//    }
//
//    protected function isOwner(User $user): bool
//    {
//        return $user->tenantRole()?->name === 'owner';
//    }
}
