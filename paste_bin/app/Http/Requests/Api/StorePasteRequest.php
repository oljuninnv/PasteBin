<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StorePasteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'expires_at' => 'nullable|date',
            'visibility' => 'required|exists:visibilities,id',
            'expiration_time' => 'required|exists:expiration_times,id',
            'language_id' => 'nullable|exists:languages,id',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Название пасты обязательно для заполнения.',
            'title.string' => 'Название пасты должно быть строкой.',
            'title.max' => 'Название пасты не должно превышать 255 символов.',
            'content.required' => 'Содержимое пасты обязательно для заполнения.',
            'content.string' => 'Содержимое пасты должно быть строкой.',
            'expires_at.date' => 'Некорректная дата для времени существования.',
            'visibility.required' => 'Выберите видимость пасты.',
            'visibility.exists' => 'Выбранный уровень доступа не существует',
            'expiration_time.required' => 'Выберите время существования пасты.',
            'expiration_time.exists' => 'Выбранное время существования пасты не существует',
            'language_id.exists' => 'Выбранный язык не существует.',
            'category_id.exists' => 'Выбранная категория не существует.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'error' => 'Ошибка в заполнении данных.',
            'messages' => $validator->errors(),
        ]));
    }
}