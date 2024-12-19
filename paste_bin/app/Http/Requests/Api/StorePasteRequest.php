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
            'visibility' => 'required|in:public,unlisted,private',
            'expiration_time' => 'required|in:10min,1hour,3hours,1day,1week,1month,never',
            'language_id' => 'nullable|exists:languages,id',
            'category_id' => 'nullable|exists:categories,id',
            'short_link' => 'required|string|unique:pastes,short_link|max:255',
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
            'visibility.in' => 'Некорректная видимость. Доступные значения: public, unlisted, private.',
            'expiration_time.required' => 'Выберите время существования пасты.',
            'expiration_time.in' => 'Некорректное время существования. Доступные значения: 10min, 1hour, 3hours, 1day, 1week, 1month, never.',
            'language_id.exists' => 'Выбранный язык не существует.',
            'category_id.exists' => 'Выбранная категория не существует.',
            'short_link.required' => 'Короткая ссылка обязательна для заполнения.',
            'short_link.string' => 'Короткая ссылка должна быть строкой.',
            'short_link.unique' => 'Эта короткая ссылка уже используется.',
            'short_link.max' => 'Короткая ссылка не должна превышать 255 символов.',
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