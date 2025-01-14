<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $success = $this->authService->login($request->only('name', 'password'));
            return response()->json($success, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->all());
        $token = $user->createToken('Access Token')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout();
            return response()->json(['message' => 'Выход из профиля прошло успешно.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Выход произвести не удалось т.к. пользователь не авторизован.'], 403);
        }
    }
}