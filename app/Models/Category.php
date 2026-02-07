<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ["id",'tenant_id'];
    protected $hidden = ['tenant_id'];

    public function budgets()
    {
        return $this->belongsToMany(Budget::class)
            ->withPivot(['allocated_amount', 'spent_amount']);
    }
}
