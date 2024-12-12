<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {        
        $values = $request->all();

        // Проверка аутентификации
        if (Auth::attempt(['email' => $values['email'], 'password' => $values['password']])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('User Token')->accessToken;

            // Формируем ответ
            $success['data'] = [
                'user' => $user,
            ];

            return $this->successResponse($success);
        }

        return $this->failureResponse(['error' => 'Ошибка в заполнении данных.']);
    }

}