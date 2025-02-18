<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Разрешаем всем пользователям использовать этот запрос
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя является обязательным полем.',
            'password.required' => 'Пароль является обязательным полем.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 409));
    }
}