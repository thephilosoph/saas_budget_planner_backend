<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $guarded = ["id"];
    protected $hidden = ['tenant_id'];

    public function budgets()
    {
        return $this->belongsToMany(Budget::class)
            ->withPivot(['allocated_amount', 'spent_amount']);
    }
}
