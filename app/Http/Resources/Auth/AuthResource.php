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
                'id'    => $this['user']->id,
                'name'  => $this['user']->name,
                'email' => $this['user']->email,
                'current_tenant_id' => $this['user']->current_tenant_id,
            ],
            'token' => [
                'access_token' => $this['token']['access_token'],
                'expires_at'   => $this['token']['expires_at'],
                'token_type'   => 'Bearer',
            ],
        ];
    }
}
