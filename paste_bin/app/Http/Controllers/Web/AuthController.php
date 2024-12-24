<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Web\LoginRequest;
use App\Models\Visibility;
use App\Enums\VisibilityEnum;
use App\Models\Paste;

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
        $publicVisibilityId = Visibility::where('name', VisibilityEnum::PUBLIC )->value('id');

        $publicPastes = Paste::where('visibility_id', $publicVisibilityId)
            ->where(function ($query) {
                $query->where('expires_at', '>', now())
                    ->orWhereNull('expires_at');
            })
            ->where('user_id', '!=', Auth::id())
             ->orWhereNull('user_id')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('pages/authPage',compact('publicPastes')); 
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
