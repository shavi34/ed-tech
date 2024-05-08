<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], ResponseAlias::HTTP_CREATED);

    }

    public function login(AuthLoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->get('email'))->first();
        if ($user && Hash::check($request->get('password'), $user->password)) {

            return response()->json([
                'message' => 'User Login successfully',
                'data' => new UserResource($user),
                'token' => $user->createToken('auth_token')->plainTextToken,
            ]);
        }

        return response()->json([
            'message' => 'Not Found',
        ], ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function show(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    public function revokeTokens(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Token deleted successfully',
        ]);
    }
}
