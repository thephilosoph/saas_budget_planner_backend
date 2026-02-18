<?php

namespace App\Services\Auth;

use App\Contracts\Repositories\Authentication\AuthRepositoryInterface;
use App\Contracts\Repositories\Authentication\PasswordResetRepositoryInterface;
use App\Contracts\Repositories\Authentication\TenantRepositoryInterface;
use App\Contracts\Repositories\Authentication\UserRepositoryInterface;
use App\Contracts\Repositories\Authorization\RoleRepositoryInterface;
use App\Contracts\Repositories\Billing\PlanRepositoryInterface;
use App\Contracts\Repositories\Billing\SubscriptionRepositoryInterface;
use App\Contracts\Repositories\Usage\UsageRepositoryInterface;
use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{

    public function __construct(
        protected AuthRepositoryInterface $authRepository,
        protected UserRepositoryInterface $users,
        protected TenantRepositoryInterface $tenants,
        protected RoleRepositoryInterface $roles,
        protected SubscriptionRepositoryInterface $subscriptions,
        protected UsageRepositoryInterface $usage,
        protected PlanRepositoryInterface $plans,
        protected PasswordResetRepositoryInterface $passwordResets,
    ) {}

    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $user = $this->users->createUser($data);
            $tenant = $this->tenants->createTenant($data['company_name'],$user->id);

            $user->current_tenant_id = $tenant->id;
            $user->save();

            $plan = $this->plans->getDefaultPlan();
            $this->subscriptions->createTrial(
                $tenant,
                $plan
            );

            $this->usage->initializeForTenant($tenant);
            $this->users->setCurrentTenant($user, $tenant->id);

            // Assign default role
            $user->assignRole(Role::OWNER);

            $token = $this->authRepository->createToken(
                $user,
                $data['device_name']
            );

            return [
                'user'  => $user,
                'token' => $token,
            ];
        });
    }

    public function login(array $credentials, string $deviceName): array
    {
//        $user = Auth::guard('web')->user();
//        if (! $user->is_active) {
//            throw ValidationException::withMessages([
//                'email' => 'Account is disabled.',
//            ]);
//       }
        $user = $this->users->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        $tokens = $this->authRepository->login($credentials['email'], $credentials['password']);

        if (!$tokens) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials']
            ]);
        }

        return [
            'user' => $user,
            'tokens' => $tokens,
        ];
    }

    public function logout(User $user): void
    {
        $accessToken = $user->token();
        $this->authRepository->logout($accessToken);
    }

    public function refreshToken(string $refreshToken): array
    {
        $tokens = $this->authRepository->refreshToken($refreshToken);

        if (!$tokens) {
            throw ValidationException::withMessages([
                'refresh_token' => ['Invalid or expired refresh token']
            ]);
        }

        return $this->formatTokenResponse($tokens);
    }

    private function formatTokenResponse(array $tokens): array
    {
        return [
            'token_type' => $tokens['token_type'],
            'expires_in' => $tokens['expires_in'],
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
        ];
    }

    public function forgotPassword(string $email): bool
    {
        $user = $this->authRepository->findByEmail($email);

        if (!$user) {
            return true;
        }

        $token = $this->passwordResets->createToken($user);

        // TODO: Dispatch event to send email
        // event(new PasswordResetRequested($user, $token));

        return true;
    }

    public function resetPassword(array $data): bool
    {
        $record = $this->passwordResets->findValidToken(
            $data['email'],
            $data['token']
        );

        if (!$record) {
            throw ValidationException::withMessages([
                'token' => 'Invalid or expired password reset token.',
            ]);
        }

        $user = $this->authRepository->findByEmail($data['email']);

        if (!$user) {
            return false;
        }

        DB::transaction(function () use ($user, $data) {
            $user->update([
                'password' => bcrypt($data['password']),
            ]);

            $this->passwordResets->deleteToken($data['email']);

            // Revoke all existing tokens for security
            $this->authRepository->revokeAllTokens($user);

            // TODO event for password reset
//            event(new PasswordReset($user));
        });

        return true;
    }

    public function changePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => bcrypt($newPassword),
        ]);

//         $this->authRepository->revokeAllTokens($user);

        return true;
    }
}
