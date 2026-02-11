<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantInvitation extends Model
{
    protected $guarded = ["id"];
    protected $hidden = ["tenant_id" , "invited_by"];
    protected $casts = ["role" => \App\Enums\Role::class];


    public function getRouteKeyName(): string
    {
        return 'token';
    }
}
