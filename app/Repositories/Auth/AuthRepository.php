<?php

namespace App\Repositories\Auth;

use App\Contracts\Repositories\Authentication\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
//use Laravel\Passport\Passport;

class AuthRepository implements AuthRepositoryInterface
{

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function createToken(User $user, string $deviceName): array
    {
        $tokenResult = $user->createToken($deviceName);
//        dd($tokenResult);
//        $tokenResult = Passport::personalAccessToken()->create(
//            $user->getKey(),
//            $deviceName
//        );

        return [
            'access_token' => $tokenResult->accessToken,
            'expires_at' => $tokenResult->expiresIn,
        ];
    }

    public function revokeCurrentToken(User $user): void
    {
        $token = $user->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id',$token->id)
            ->update(['revoked' => true]);
        $token->revoke();
    }
}
