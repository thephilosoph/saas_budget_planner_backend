<?php

namespace App\Repositories\Authorization;

use App\Contracts\Repositories\Authorization\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function getOwnerRole(): Role
    {
        return cache()->rememberForever('role.owner', fn () =>
        Role::where('name', 'owner')->firstOrFail()
        );
    }
}
