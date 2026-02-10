<?php

namespace App\Models;

// use Illuminate\Contracts\Authentication\MustVerifyEmail;
use App\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $guard_name = 'api';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'current_tenant_id',
        'is_active',
    ];

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class)
            ->withPivot('role_id', 'joined_at');
    }

    public function getCurrentTenant(): int
    {
        return $this->current_tenant_id;
    }

    public function setCurrentTenant($tenantId): void
    {
        $this->current_tenant_id = $tenantId;
        $this->save();
    }

    // Override the tenant getter if needed
    protected function getTenantIdForRole(): ?int
    {
        return $this->current_tenant_id;
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
