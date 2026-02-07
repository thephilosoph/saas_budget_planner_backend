<?php

namespace App\Contracts\Repositories\Authorization;

use App\Models\Role;

interface RoleRepositoryInterface
{
    public function getOwnerRole(): Role;

}
