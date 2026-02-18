<?php

namespace App\Contracts\Repositories\Authentication;

interface AuthRepositoryInterface
{
    public function login(string $email, string $password): ?array;

    public function refreshToken(string $refreshToken): ?array;

    public function logout(string $accessToken): void;
}
