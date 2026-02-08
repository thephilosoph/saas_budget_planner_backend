<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
//    protected $fillable = ['name', 'slug', 'created_by'];
//    protected $casts = ['trial_ends_at' => 'datetime'];
    protected $guarded = ['id','created_by','stripe_customer_id','pm_type','pm_last_four'];
    protected $hidden = ['stripe_customer_id','pm_type','pm_last_four'];

    public function users() {
        return $this->belongsToMany(User::class, 'tenant_user')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }
}
