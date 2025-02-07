<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->validated('email'))->first();

        if (!isset($user) || !Hash::check($request->validated('password'), $user->password)) {
            return response()->json([
                'message' => __('auth.login.credentials')
            ], 403);
        }

        $token = $user->createToken('App')->plainTextToken;

        return response()->json([
            'message' => __('auth.login.success'),
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        if (!$request->user()->currentAccessToken()->delete()) {
            return response()->json([
                'message' => __('auth.logout.current_token'),
            ], 500);
        }

        return response()->json([
            'message' => __('auth.logout.success')
        ]);
    }
}
