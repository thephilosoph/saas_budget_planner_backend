<?php

namespace App\Traits;

use Spatie\Permission\Traits\HasRoles as SpatieHasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles
{
    use SpatieHasRoles {
        SpatieHasRoles::roles as spatieRoles;
    }

    /**
     * Override the roles relationship to include tenant_id in pivot
     */
    public function roles(): BelongsToMany
    {
        $relation = $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            config('permission.column_names.role_pivot_key') ?? 'role_id'
        );

        return $relation->withPivot('tenant_id');
    }

    /**
     * Assign the given role to the model with tenant context.
     *
     * @param string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles
     * @return $this
     */
    public function assignRole(...$roles)
    {
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) {
                if (empty($role)) {
                    return false;
                }
                return $this->getStoredRole($role);
            })
            ->filter(function ($role) {
                return $role instanceof \Spatie\Permission\Contracts\Role;
            })
            ->each(function ($role) {
                $this->ensureModelSharesGuard($role);
            })
            ->map->getKey()
            ->all();

        $tenantId = $this->getTenantIdForRole();

        $model = $this->getModel();

        if ($model->exists) {
            // Get existing role IDs for this tenant
            $existingRoleIds = $model->roles()
                ->where('model_has_roles.tenant_id', $tenantId) // Use where on table, not wherePivot
                ->pluck('roles.id')
                ->toArray();

            $newRoleIds = array_diff($roles, $existingRoleIds);

            // Attach only new roles with tenant_id
            foreach ($newRoleIds as $roleId) {
                $model->roles()->attach($roleId, ['tenant_id' => $tenantId]);
            }
        } else {
            $class = \get_class($model);

            $class::saved(
                function ($object) use ($roles, $model, $tenantId) {
                    if ($model->getKey() && $model->getKey() === $object->getKey()) {
                        foreach ($roles as $roleId) {
                            $model->roles()->attach($roleId, ['tenant_id' => $tenantId]);
                        }
                        $object->unsetRelation('roles');
                    }
                }
            );
        }

        $this->unsetRelation('roles');

        return $this;
    }

    /**
     * Remove all current roles and set the given ones with tenant context.
     *
     * @param string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles
     * @return $this
     */
    public function syncRoles(...$roles)
    {
        $tenantId = $this->getTenantIdForRole();

        // Detach only roles for current tenant
        $this->roles()
            ->wherePivot('tenant_id', $tenantId)
            ->detach();

        return $this->assignRole($roles);
    }

    /**
     * Revoke the given role from the model.
     *
     * @param string|int|\Spatie\Permission\Contracts\Role $role
     * @return $this
     */
    public function removeRole($role)
    {
        $tenantId = $this->getTenantIdForRole();
        $roleId = $this->getStoredRole($role)->getKey();

        $this->roles()
            ->wherePivot('tenant_id', $tenantId)
            ->wherePivot(config('permission.column_names.role_pivot_key') ?? 'role_id', $roleId)
            ->detach();

        $this->unsetRelation('roles');

        return $this;
    }

    /**
     * Get the tenant_id for role assignment.
     *
     * @return int|null
     */
    protected function getTenantIdForRole(): ?int
    {
        // Try to get from current_tenant_id property
        if (property_exists($this, 'current_tenant_id') && $this->current_tenant_id) {
            return $this->current_tenant_id;
        }

        // Try to get from currentTenant relationship
        if (method_exists($this, 'currentTenant') && $this->currentTenant) {
            return $this->currentTenant->id;
        }

        // Try to get from tenant relationship
        if (method_exists($this, 'tenant') && $this->tenant) {
            return $this->tenant->id;
        }

        return null;
    }
}
