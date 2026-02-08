<?php

namespace App\Repositories\Auth;

use App\Contracts\Repositories\Authentication\TenantInvitationRepositoryInterface;
use App\Models\TenantInvitation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantInvitationRepository implements TenantInvitationRepositoryInterface
{

    public function inviteUserToTenant(array $data)
    {
        return DB::transaction(function () use ($data) {
            return TenantInvitation::create([
                'tenant_id'  => $data['tenant_id'],
                'email'      => $data['email'],
                'role'       => $data['role'],
                'token'      => Str::uuid(),
                'expires_at' => now()->addDays(7),
                'invited_by' => auth()->id(),
            ]);
        });
    }
    public function findByToken(string $token): ?TenantInvitation
    {
        return TenantInvitation::where('token', $token)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();
    }

    public function delete(int $id): bool
    {
        return TenantInvitation::where('id',$id)->delete();
    }
}
