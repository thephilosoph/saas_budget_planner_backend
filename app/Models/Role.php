<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // Add domain helpers if needed
    public function isOwner(): bool
    {
        return $this->name === 'owner';
    }
}


