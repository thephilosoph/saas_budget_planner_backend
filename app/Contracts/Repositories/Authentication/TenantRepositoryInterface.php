<?php

namespace App\Contracts\Repositories\Authentication;

use App\Contracts\Repositories\BaseRepositoryInterface;
use App\Models\Tenant;
use App\Models\User;

interface TenantRepositoryInterface  extends BaseRepositoryInterface
{
    public function createTenant(string $name, int $creator_id): Tenant;

    public function attachUser(Tenant $tenant, User $user, int $roleId): void;
}
