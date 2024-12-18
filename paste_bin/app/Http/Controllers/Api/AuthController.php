<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {        
        $values = $request->all();

        if (Auth::attempt(['name' => $values['name'], 'password' => $values['password']])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('User Token')->accessToken;

            $success['data'] = [
                'user' => $user,
            ];

            return $this->successResponse($success);
        }

        return $this->failureResponse(['error' => 'Ошибка в заполнении данных.']);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        // Валидация данных запроса
        $values = $request->all();
            // Создание нового пользователя
            $user = new User;
            $user->name = $values['name'];
            $user->email = $values['email'];
            $user->password = Hash::make($values['password']);
            $user->save();

            // Генерация токена доступа
            $token = $user->createToken('Access Token')->accessToken;
            $data = [
                'user' => $user,
                'access_token' => $token,
            ];

            return response()->json($data, 200);
    } 

    public function logout(Request $request){
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(['message' => 'User logged out successfully.'], 200);
    }

}