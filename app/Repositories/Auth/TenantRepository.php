<?php

namespace App\Repositories\Auth;

use App\Contracts\Repositories\Authentication\TenantRepositoryInterface;
use App\Models\Tenant;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TenantRepository extends BaseRepository implements TenantRepositoryInterface
{
    public function __construct(Tenant $model)
    {
        parent::__construct($model);
    }

    public function createTenant(string $name, int $creator_id): Tenant
    {
        return $this->create([
            'name' => $name,
            'slug' => \Str::slug($name) . '-' . \Str::random(5),
            'created_by'=>$creator_id
        ]);
    }

    public function attachUser(Tenant $tenant, User $user, int $roleId): void
    {
        $tenant->users()->attach($user->id, [
            'role_id' => $roleId,
            'joined_at' => now(),
        ]);
    }
}
