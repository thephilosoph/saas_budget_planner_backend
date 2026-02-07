<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends BaseResource
{
    public function toArray($request): array
    {
        return $this->successResponse([
            'user' => [
                'id'    => $this['user']->id,
                'name'  => $this['user']->name,
                'email' => $this['user']->email,
            ],
            'token' => [
                'access_token' => $this['token']['access_token'],
                'expires_at'   => $this['token']['expires_at'],
            ],
        ]);
    }
}
