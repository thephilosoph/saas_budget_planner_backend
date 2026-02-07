<?php

namespace App\Contracts\Repositories\Authentication;

use App\Contracts\Repositories\BaseRepositoryInterface;
use App\Models\User;

interface UserRepositoryInterface  extends BaseRepositoryInterface
{
    public function createUser(array $data): User;

    public function findByEmail(string $email): ?User;

    public function setCurrentTenant(User $user, int $tenantId): void;
}
