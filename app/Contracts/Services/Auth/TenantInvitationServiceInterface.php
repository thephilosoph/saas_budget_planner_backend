<?php

namespace App\Contracts\Services\Auth;

interface TenantInvitationServiceInterface
{
    public function inviteUser(array $data);

    public function accept(string $token);

    public function delete(int $id);
}
