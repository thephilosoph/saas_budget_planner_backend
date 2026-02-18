<?php

namespace App\Contracts\Repositories\Authentication;

use App\Models\User;

interface PasswordResetRepositoryInterface
{
    public function createToken(User $user): string;

    public function findValidToken(string $email, string $token): ?object;

    public function deleteToken(string $email): void;

    public function deleteExpiredTokens(): void;

}
