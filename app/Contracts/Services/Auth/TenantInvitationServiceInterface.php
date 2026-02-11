<?php

namespace App\Contracts\Services\Auth;

use App\Models\TenantInvitation;

interface TenantInvitationServiceInterface
{
    public function inviteUser(array $data);

    public function accept(TenantInvitation $invitation, array $data);

    public function delete(int $id);

    public function findOrFail(string $token);
}
