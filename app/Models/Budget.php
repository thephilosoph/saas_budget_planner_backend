<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use Auditable;

    protected $guarded = ['id'];
    protected $hidden = ['tenant_id'];


    public function categories()
    {
        return $this->belongsToMany(Category::class)
            ->withPivot(['allocated_amount', 'spent_amount', 'notes'])
            ->withTimestamps();
    }

    public function shouldAudit(string $action): bool
    {
        return in_array($action, ['created', 'updated', 'deleted']);
    }
}
