<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user' => [
                'id' => $this['user']->id,
                'name' => $this['user']->name,
                'email' => $this['user']->email,
                'current_tenant_id' => $this['user']->current_tenant_id,
            ],

            'auth' => [
                'token_type' => $this['tokens']['token_type'],
                'access_token' => $this['tokens']['access_token'],
                'refresh_token' => $this['tokens']['refresh_token'],
                'expires_in' => $this['tokens']['expires_in'],
                'expires_at' => now()->addSeconds($this['tokens']['expires_in'])->toISOString(),
            ],
        ];
    }
}
