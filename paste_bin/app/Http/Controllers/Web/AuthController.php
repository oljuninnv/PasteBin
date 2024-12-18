<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        
        Auth::logout();

        return redirect()->route('home');
    }

    public function showLoginForm()
    {
        return view('pages/authPage'); 
    }

    public function login(LoginRequest $request){

        $values = $request->all();


        if (Auth::attempt(['name' => $values['name'], 'password' => $values['password']])) {
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
