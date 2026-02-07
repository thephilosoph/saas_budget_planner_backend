<?php

namespace App\Http\Controllers;

use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    public function login(LoginRequest $request){
        $result = $this->authService->login($request->only(['email', 'password']),$request->device_name);
        return new AuthResource($result);
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->only(['name', 'email', 'password', 'device_name','company_name']));
        return new AuthResource($result);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Logged out successfully']);
    }

}
