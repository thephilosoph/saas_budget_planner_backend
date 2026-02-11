<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateTenantInvitationRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\TenantInvitation;
use App\Services\Auth\TenantInvitationService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TenantInvitationController extends Controller
{
    use AuthorizesRequests;
    public function __construct(protected TenantInvitationService $invitationService)
    {}

    public function accept(TenantInvitation $invitation, RegisterRequest $request)
    {

        Gate::authorize('accept', [$invitation, $request->email]);
        return $this->invitationService->accept($invitation, $request->validated());
    }

    public function create(CreateTenantInvitationRequest $request){
        return $this->invitationService->inviteUser($request->validated());
    }

    public function show(string $token)
    {
        return $this->invitationService->findOrFail($token);
    }

    public function delete(Request $request)
    {
        return $this->invitationService->delete($request["invitation_id"]);
    }
}
