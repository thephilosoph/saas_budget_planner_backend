<?php

namespace App\Repositories\Auth;

use App\Contracts\Repositories\Authentication\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

//use Laravel\Passport\Passport;

class AuthRepository implements AuthRepositoryInterface
{

    private function oauthUrl(): string
    {
        return url('/oauth/token');
    }
    private function revokeUrl(): string
    {
        return config('app.url') . '/api/auth/logout';
    }

    private function refreshUrl(): string
    {
        return config('app.url') . '/api/auth/login';
    }


    public function login(string $email, string $password): ?array
    {
//        $response = Http::asForm()->post($this->oauthUrl(), [
//            'grant_type' => 'password',
//            'client_id' => config('services.passport.password_client_id'),
//            'client_secret' => config('services.passport.password_client_secret'),
//            'username' => $email,
//            'password' => $password,
//            'scope' => '',
//        ]);
        $response = $this->requestToken([
            'grant_type' => 'password',
            'client_id' => config('services.passport.password_client_id'),
            'client_secret' => config('services.passport.password_client_secret'),
            'username' => $email,
            'password' => $password,
            'scope' => '',
        ]);

        return  $response ;
    }

    public function refreshToken(string $refreshToken): ?array
    {
//        $response = Http::asForm()->post($this->refreshUrl(), [
//            'grant_type' => 'refresh_token',
//            'refresh_token' => $refreshToken,
//            'client_id' => config('services.passport.password_client_id'),
//            'client_secret' => config('services.passport.password_client_secret'),
//            'scope' => '',
//        ]);

        return $this->requestToken([
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => config('services.passport.password_client_id'),
            'client_secret' => config('services.passport.password_client_secret'),
            'scope' => '',
        ]);
    }

    public function logout(string $accessToken): void
    {
        Http::withToken($accessToken)->delete($this->revokeUrl());
    }

    private function requestToken(array $data): array
    {
        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);

        $content = json_decode($response->getContent(), true);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception($content['message'] ?? 'OAuth error');
        }

        return $content;
    }
}
