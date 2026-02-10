<?php

namespace App\Contracts\Services\Auth;

interface TenantInvitationServiceInterface
{
    public function inviteUser(array $data);

    public function accept(string $token, array $data);

    public function delete(int $id);
}
