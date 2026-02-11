<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use Auditable;

    protected $hidden = ['tenant_id'];
    protected $guarded = ['id'];

    public function shouldAudit(string $action): bool
    {
        return in_array($action, ['created', 'updated', 'deleted']);
    }
}
