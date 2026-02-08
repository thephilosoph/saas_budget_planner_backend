<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy extends BasePolicy
{

    public function view(User $user, Category $category): bool
    {
        return $this->belongsToTenant($user, $category)
            && $this->hasTenantPermission($user, 'tenant:categories.view');
    }

    public function create(User $user): bool
    {
        return $this->hasTenantPermission($user, 'tenant:categories.create');
    }

    public function update(User $user, Category $category): bool
    {
        return $this->belongsToTenant($user, $category)
            && $this->hasTenantPermission($user, 'tenant:categories.update');
    }

    public function delete(User $user, Category $category): bool
    {
        return $this->belongsToTenant($user, $category)
            && $this->hasTenantPermission($user, 'tenant:categories.delete');
    }
}
