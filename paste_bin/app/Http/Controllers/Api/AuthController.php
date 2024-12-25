<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {        
        $values = $request->all();

        if (Auth::attempt(['name' => $values['name'], 'password' => $values['password']])) {
            $user = Auth::user();
            if (!$user->banned){
                $success['token'] = $user->createToken('User Token')->accessToken;

                $success['data'] = [
                    'user' => $user,
                ]; 
            }
            else{
                return response()->json(['message' => 'Ваш профиль заблокирован.']);
            }
        
            return $this->successResponse($success);
        }

        return response()->json(['message' => 'Ошибка в заполнении данных'], 409);
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