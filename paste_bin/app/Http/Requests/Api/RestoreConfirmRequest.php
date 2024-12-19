<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RestoreConfirmRequest extends FormRequest
{
    public function rules()
    {
        return [
            'token' => 'required|string|regex:/^[a-zA-Z0-9]+$/', // Формат токена: %d-%s
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|same:password',
        ];
    }

    public function messages()
{
    return [
        'token.required' => 'Токен является обязательным полем.',
        'token.string' => 'Токен должен быть строкой.',
        'token.regex' => 'Токен должен содержать только буквы и цифры.',
        
        'password.required' => 'Пароль является обязательным полем.',
        'password.string' => 'Пароль должен быть строкой.',
        'password.min' => 'Пароль должен содержать минимум 6 символов.',
        
        'password_confirmation.required' => 'Подтверждение пароля является обязательным полем.',
        'password_confirmation.string' => 'Подтверждение пароля должно быть строкой.',
        'password_confirmation.same' => 'Пароли не совпадают.',
    ];
}

protected function failedValidation(Validator $validator)
{
    throw new ValidationException($validator, response()->json([
        'error' => 'Ошибка в заполнении данных.',
        'messages' => $validator->errors(),
    ]));
}


    public function authorize()
    {
        return true; // Разрешаем все запросы
    }
}
