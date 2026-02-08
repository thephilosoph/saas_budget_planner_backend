<?php

namespace App\Contracts\Repositories\Authentication;

use App\Models\Tenant;
use App\Models\TenantInvitation;

interface TenantInvitationRepositoryInterface
{
    public function inviteUserToTenant(array $data);
    public function findByToken(string $token): ?TenantInvitation;
    public function delete(int $id): bool;

}
