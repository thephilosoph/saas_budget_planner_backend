<?php

namespace App\Contracts\Repositories\Authentication;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function createToken(User $user, string $deviceName): array;

    public function revokeCurrentToken(User $user): void;
}
