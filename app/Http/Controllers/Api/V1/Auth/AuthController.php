<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        $user = User::create($data);

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'message' => 'Account created successfully',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials.'], 400);
        }

        $user = User::where('email', $credentials['email'])->first();

        $user->tokens()->delete();

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'message'=>'Login Successfully',
            'user'  => $user,
            'token' => $token,
        ]);
    }

    public function logout(): JsonResponse
    {
        $user = request()->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out.']);
    }
}
