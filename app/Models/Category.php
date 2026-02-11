<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use Auditable;

    protected $guarded = ["id"];
    protected $hidden = ['tenant_id'];

    public function budgets()
    {
        return $this->belongsToMany(Budget::class)
            ->withPivot(['allocated_amount', 'spent_amount']);
    }

    public function shouldAudit(string $action): bool
    {
        return in_array($action, ['created', 'updated', 'deleted']);
    }
}
