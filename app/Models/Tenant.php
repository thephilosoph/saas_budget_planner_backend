<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use Auditable;

    protected $guarded = ['id','created_by','stripe_customer_id','pm_type','pm_last_four'];
    protected $hidden = ['stripe_customer_id','pm_type','pm_last_four'];

    public function users() {
        return $this->belongsToMany(User::class, 'tenant_user')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function shouldAudit(string $action): bool
    {
        return in_array($action, ['created', 'updated', 'deleted']);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
