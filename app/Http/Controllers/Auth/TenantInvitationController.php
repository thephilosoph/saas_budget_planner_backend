<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateTenantInvitationRequest;
use App\Services\Auth\TenantInvitationService;
use Illuminate\Http\Request;

class TenantInvitationController extends Controller
{
    public function __construct(protected TenantInvitationService $invitationService)
    {}

    public function create(CreateTenantInvitationRequest $request){
        return $this->invitationService->inviteUser($request->validated());
    }

    public function delete(Request $request)
    {
        return $this->invitationService->delete($request["invitation_id"]);
    }
}
