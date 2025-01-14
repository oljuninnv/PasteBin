<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user->banned) {
                return [
                    'token' => $user->createToken('User Token')->accessToken,
                    'user' => $user,
                ];
            } else {
                throw new \Exception('Ваш профиль заблокирован.');
            }
        }

        throw new \Exception('Ошибка в заполнении данных');
    }

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function logout(): void
    {
        $user = Auth::user();
        $this->userRepository->deleteTokens($user);
    }
}