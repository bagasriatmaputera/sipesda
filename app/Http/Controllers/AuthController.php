<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function login(LoginRequest $loginRequest)
    {
        return $this->authService->login($loginRequest->validated());
    }

    public function register(RegisterRequest $registerRequest)
    {
        return $this->authService->register($registerRequest->validated());
    }

    public function tokenLogin(LoginRequest $loginRequest)
    {
        return $this->authService->tokenLogin($loginRequest->validated());
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logout Successfully'
        ]);
    }
    public function user(Request $request)
    {
        return response()->json(['data' => new UserResource($request->user())]);
    }
}
