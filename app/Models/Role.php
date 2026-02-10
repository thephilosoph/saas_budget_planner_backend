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


//    public function scopeRole($query, $role, $guard = null)
//    {
//        return $query
//            ->where('name', $role)
//            ->where('guard_name', $guard ?? config('auth.defaults.guard'));
//    }
}


