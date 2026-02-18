<?php

namespace App\Repositories\Auth;

use App\Contracts\Repositories\Authentication\PasswordResetRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetRepository implements PasswordResetRepositoryInterface
{

    public function createToken(User $user): string
    {
        $this->deleteToken($user->email);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email'      => $user->email,
            'token'      => Hash::make($token),
            'created_at' => now(),
        ]);

        return $token;
    }

    public function findValidToken(string $email, string $token): ?object
    {
        $record = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if (!$record) {
            return null;
        }

        if (!Hash::check($token, $record->token)) {
            return null;
        }

        // Token expires after 60 minutes
        if (now()->diffInMinutes($record->created_at) > 60) {
            return null;
        }

        return $record;
    }

    public function deleteToken(string $email): void
    {
        DB::table('password_resets')
            ->where('email', $email)
            ->delete();
    }

    public function deleteExpiredTokens(): void
    {
        DB::table('password_resets')
            ->where('created_at', '<', now()->subMinutes(60))
            ->delete();
    }
}
