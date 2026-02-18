<?php

namespace App\Contracts\Repositories\Authentication;

use App\Models\User;

interface AuthRepositoryPersonalAccessInterface
{
    public function findByEmail(string $email): ?User;

    public function createToken(User $user, string $deviceName): array;

    public function revokeCurrentToken(User $user): void;

    public function createRefreshToken(User $user, string $deviceName): string;
    public function revokeAllTokens(User $user): void;

    public function findToken(string $tokenId): ?object;

    public function refreshAccessToken(string $refreshToken): ?array;
}
