<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();

        // Возвращаемся на предыдущую страницу
        return redirect()->back();
    }

    public function showLoginForm()
    {
        return view('pages/authPage'); 
    }

    public function login(Request $request){
        $messages = [
            'name.required' => 'Поле email обязательно для заполнения.',
            'password.required' => 'Поле пароля обязательно для заполнения.',
        ];

        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ], $messages);

        if (Auth::attempt($request->only('name', 'password'))) {
            $user = Auth::user();

            if ($user->banned == 1) {
                Auth::logout();
                return back()->withErrors([
                    'credentials' => 'Ваш профиль заблокирован.',
                ])->withInput();
            }

            return redirect('/');
        }

        return back()->withErrors([
            'credentials' => 'Неверные учетные данные.',
        ])->withInput();
    
    }
}
