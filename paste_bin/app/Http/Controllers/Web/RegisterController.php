<?php

namespace App\Http\Controllers\web;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $messages = [
            'name.required' => 'Имя является обязательным полем.',
            'name.max' => 'Имя не должно быть длиннее 255 символов.',
            'name.min' => 'Имя не должно быть меньше 3-х символов',
            'email.required' => 'Email является обязательным полем.',
            'email.email' => 'Некорректный формат email.',
            'email.unique' => 'Пользователь с таким email уже существует.',
            'password.required' => 'Пароль является обязательным полем.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
        ];
    
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], $messages);
    
        try {
            // Создание нового пользователя
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
    
            // Авторизация пользователя
            Auth::login($user);
    
            return redirect('/')->with('success', 'Регистрация прошла успешно!');
        } catch (\Exception $e) {
            // Обработка исключений
            return redirect()->back()->withErrors(['error' => 'Произошла ошибка при регистрации. Пожалуйста, попробуйте еще раз.']);
        }
    }

    public function showRegisterForm()
    {
        return view('pages/registerPage');
    }
}
