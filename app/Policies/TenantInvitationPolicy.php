<?php

namespace App\Policies;

use App\Models\TenantInvitation;
use App\Models\User;

class TenantInvitationPolicy extends BasePolicy
{
//    public function create(User $user): bool
//    {
//        return $this->hasTenantPermission($user, 'tenant:invitation.create');
//    }
//
//    public function view(User $user): bool
//    {
//        return $this->hasTenantPermission($user, 'tenant:invitation.view');
//    }
//
//    public function delete(User $user): bool
//    {
//        return $this->hasTenantPermission($user, 'tenant:invitation.delete');
//    }

    public function accept(?User $user, TenantInvitation $invitation , string $email): bool
    {
//        return ($invitation->accepted_at == null) &&
//            ($invitation->expires_at > now()) &&
//            ($invitation->email === $email);

        if ($invitation->accepted_at !== null) {
            return false;
        }

        if ($invitation->expires_at <= now()) {
            return false;
        }

        if ($user) {
            return $user->email === $invitation->email;
        }

        return true;

    }
}
