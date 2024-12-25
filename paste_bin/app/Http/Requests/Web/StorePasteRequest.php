<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StorePasteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'expires_at' => 'nullable',
            'visibility_id' => 'required|exists:visibilities,id',
            'expiration_time' => 'required|exists:expiration_times,id',
            'language_id' => 'nullable|exists:languages,id',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название пасты обязательно для заполнения.',
            'title.string' => 'Название пасты должно быть строкой.',
            'title.max' => 'Название пасты не должно превышать 255 символов.',
            'content.required' => 'Содержимое пасты обязательно для заполнения.',
            'content.string' => 'Содержимое пасты должно быть строкой.',
            'visibility_id.required' => 'Выберите видимость пасты.',
            'visibility_id.exists' => 'Выбранный уровень доступа не существует',
            'expiration_time.required' => 'Выберите время существования пасты.',
            'expiration_time.exists' => 'Выбранное время существования пасты не существует',
            'language_id.exists' => 'Выбранный язык не существует.',
            'category_id.exists' => 'Выбранная категория не существует.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}