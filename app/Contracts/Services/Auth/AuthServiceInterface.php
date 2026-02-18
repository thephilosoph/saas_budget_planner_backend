<?php

namespace App\Contracts\Services\Auth;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): array;
    public function login(array $credentials, string $deviceName): array;

    public function logout(User $user): void;

    public function refreshToken(string $refreshToken): array;

    public function forgotPassword(string $email): bool;

    public function resetPassword(array $data): bool;

    public function changePassword(User $user, string $currentPassword, string $newPassword): bool;


}
