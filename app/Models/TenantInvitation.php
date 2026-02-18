<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class TenantInvitation extends Model
{
    use Auditable;
    protected $guarded = ["id"];
    protected $hidden = ["tenant_id" , "invited_by"];
    protected $casts = ["role" => \App\Enums\Role::class];


    public function getRouteKeyName(): string
    {
        return 'token';
    }

    public function shouldAudit(string $action): bool
    {
        return in_array($action, ['created', 'deleted']);
    }
}
