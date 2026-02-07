<?php

namespace App\Services\Auth;

use App\Contracts\Repositories\Authentication\AuthRepositoryInterface;
use App\Contracts\Repositories\Authentication\TenantRepositoryInterface;
use App\Contracts\Repositories\Authentication\UserRepositoryInterface;
use App\Contracts\Repositories\Authorization\RoleRepositoryInterface;
use App\Contracts\Repositories\Billing\PlanRepositoryInterface;
use App\Contracts\Repositories\Billing\SubscriptionRepositoryInterface;
use App\Contracts\Repositories\Usage\UsageRepositoryInterface;
use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    ) {}

    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $user = $this->users->createUser($data);
            $tenant = $this->tenants->createTenant($data['company_name'],$user->id);
            $user->current_tenant_id = $tenant->id;

            $plan = $this->plans->getDefaultPlan();

            $this->subscriptions->createTrial(
                $tenant,
                $plan
            );

            $this->usage->initializeForTenant($tenant);
            $this->users->setCurrentTenant($user, $tenant->id);

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

        if (!Auth::guard('web')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        $user = Auth::guard('web')->user();
        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => 'Account is disabled.',
            ]);
        }
        $token = $this->authRepository->createToken($user, $deviceName);
        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        $this->authRepository->revokeCurrentToken($user);
    }
}
