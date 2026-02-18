<?php

namespace App\Repositories\Auth;

use App\Contracts\Repositories\Authentication\AuthRepositoryPersonalAccessInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

//use Laravel\Passport\Passport;

class AuthRepositoryPersonalAccess implements AuthRepositoryPersonalAccessInterface
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
            'token_type'   => 'Bearer',
            'expires_in'   => $tokenResult->token->expires_at->diffInSeconds(now()),
            'refresh_token' => $this->createRefreshToken($user, $deviceName),
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

    public function createRefreshToken(User $user, string $deviceName): string
    {
        $refreshToken = $user->createToken($deviceName . '_refresh', ['refresh']);

        DB::table('oauth_refresh_tokens')->insert([
            'id'           => Str::uuid(),
            'access_token_id' => $refreshToken->token->id,
            'revoked'      => false,
            'expires_at'   => now()->addDays(30),
        ]);

        return $refreshToken->accessToken;
    }

    public function revokeAllTokens(User $user): void
    {
        $user->tokens()->update(['revoked' => true]);

        DB::table('oauth_refresh_tokens')
            ->whereIn('access_token_id', function ($query) use ($user) {
                $query->select('id')
                    ->from('oauth_access_tokens')
                    ->where('user_id', $user->id);
            })
            ->update(['revoked' => true]);
    }


    public function findToken(string $tokenId): ?object
    {
        return DB::table('oauth_access_tokens')
            ->where('id', $tokenId)
            ->first();
    }

    public function refreshAccessToken(string $refreshToken): ?array
    {
        try {
            $token = DB::table('oauth_access_tokens')
                ->where('id', $this->extractTokenId($refreshToken))
                ->where('revoked', false)
                ->first();

            if (!$token) {
                return null;
            }
            $user = User::find($token->user_id);

            if (!$user) {
                return null;
            }
            $this->revokeCurrentToken($user);

            return $this->createToken($user, $refreshToken);
        }catch (\Exception $exception){
            return null;
        }

    }


    private function extractTokenId(string $token): string
    {
        // Extract token ID from JWT or plain token
        return explode('|', $token)[1] ?? $token;
    }

    private function isRefreshTokenExpired(string $accessTokenId): bool
    {
        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessTokenId)
            ->first();

        return !$refreshToken ||
            $refreshToken->revoked ||
            now()->gt($refreshToken->expires_at);
    }
}
