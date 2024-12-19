<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;
        return [
            'email' => 'required|email|unique:users,email,' . $userId,
            'website' => 'nullable|url|regex:/^https?:\/\/.+$/',
            'location' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Пожалуйста, введите вашу почту.',
            'email.unique' => 'Пользователь с таким email уже существует.',
            'email.email' => 'Пожалуйста, введите корректный адрес электронной почты.',
            'website.url' => 'Пожалуйста, введите корректный URL.',
            'website.regex' => 'Введите корректный URL, начинающийся с http(s)://.',
            'location.string' => 'Местоположение должно быть строкой.',
            'location.max' => 'Местоположение не должно превышать 255 символов.',
            'avatar.image' => 'Файл должен быть изображением.',
            'avatar.mimes' => 'Допустимые форматы: jpeg, png, jpg',
            'avatar.max' => 'Размер файла не должен превышать 2 МБ.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
        ];
    }
}