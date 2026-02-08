<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $guarded = ['tenant_id','id'];
    protected $hidden = ['tenant_id'];


    public function categories()
    {
        return $this->belongsToMany(Category::class)
            ->withPivot(['allocated_amount', 'spent_amount', 'notes'])
            ->withTimestamps();
    }
}
