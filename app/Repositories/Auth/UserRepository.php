<?php

namespace App\Repositories\Auth;

use App\Contracts\Repositories\Authentication\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function createUser(array $data): User
    {
        return $this->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function setCurrentTenant(User $user, int $tenantId): void
    {
        $user->update(['current_tenant_id' => $tenantId]);
    }

    public function findByEmail(string $email): ?User
    {
        // TODO: Implement findByEmail() method.
    }
}
