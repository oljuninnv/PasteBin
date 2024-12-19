<?php

namespace App\Http\Controllers\web;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\RegisterRequest;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $values = $request->all();
    
        try {
            // Создание нового пользователя
            $user = new User;
            $user->name = $values['name'];
            $user->email = $values['email'];
            $user->password = Hash::make($values['password']);
            $user->save();
    
            // Авторизация пользователя
            Auth::login($user);
    
            return redirect('/')->with('success', 'Регистрация прошла успешно!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Произошла ошибка при регистрации. Пожалуйста, попробуйте еще раз.']);
        }
    }

    public function showRegisterForm()
    {
        return view('pages/registerPage');
    }
}
