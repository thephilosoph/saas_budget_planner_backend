<?php

namespace App\Services\Auth;

use App\Contracts\Repositories\Authentication\TenantInvitationRepositoryInterface;
use App\Contracts\Services\Auth\TenantInvitationServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantInvitationService implements TenantInvitationServiceInterface
{
    public function __construct(
        private TenantInvitationRepositoryInterface $repository
    ) {}

    public function inviteUser(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = auth()->user();
            $invitation = $this->repository->create([
                'tenant_id'  => $user->current_tenant_id,
                'email'      => $data['email'],
                'role'       => $data['role'],
                'token'      => Str::uuid(),
                'expires_at' => now()->addDays(7),
                'invited_by' => $user->id,
            ]);

            // TODO  event(new TenantInvited($invitation));

            return $invitation;
        });
    }

    public function accept(string $token)
    {
        return DB::transaction(function () use ($token) {
            $invite = $this->repository->findByToken($token);
            $user = auth()->user();

            DB::table('tenant_user')->updateOrInsert([
                'tenant_id' => $invite->tenant_id,
                'user_id'   => $user->id,
            ], [
                'joined_at' => now(),
            ]);
            $user->assignRole(
                $invite->role,
                'api',
                $invite->tenant_id
            );

            $invite->update([
                'accepted_at' => now(),
            ]);

            return true;
        });
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
