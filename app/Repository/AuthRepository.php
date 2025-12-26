<?php

namespace App\Repository;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function login(array $data)
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials do not match aur records'
            ]);
        }

        request()->session()->regenerate();

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'data' => new UserResource($user)
        ]);
    }

    public function tokenLogin(array $data)
    {
        if (!Auth::attempt($data['email'], $data['password'])) {
            return response()->json([
                'message' => 'Invalid credentials'
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;
        return response()->json([
            'status' => 'succes',
            'token' => $token,
            'data' => new UserResource($user)
        ]);
    }
}
