<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Проверка, существует ли пользователь с таким же email
            $user = User::where('email', $socialUser->getEmail())->first();

            // Если пользователь не найден, создаем нового
            if (!$user) {
                $user = User::create([
                    'name' => !empty($socialUser->username) || !empty($socialUser->nickname)
                    ? ($socialUser->username ?: $socialUser->nickname)
                    : User::generateUserName($socialUser->getNickname()),
                    'email' => $socialUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'provider_token' => $socialUser->token,
                    'email_verified_at' => now(),
                ]);
            } else {
                // Если пользователь найден, проверяем совпадение данных
                $updated = false;

                if ($user->provider !== $provider) {
                    $user->provider = $provider;
                    $updated = true;
                }

                if ($user->provider_id !== $socialUser->getId()) {
                    $user->provider_id = $socialUser->getId();
                    $updated = true;
                }

                if ($user->provider_token !== $socialUser->token) {
                    $user->provider_token = $socialUser->token;
                    $updated = true;
                }

                // Сохраняем изменения, если что-то было обновлено
                if ($updated) {
                    $user->save();
                }
            }

            // Авторизуем пользователя
            Auth::login($user);
            return redirect('/');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }
}
