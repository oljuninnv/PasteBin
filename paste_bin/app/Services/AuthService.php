<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * Class AuthService
 */
class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array<string, mixed> $credentials
     * @return array
     */
    public function login(array $credentials): array
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (isset($user->banned) && !$user->banned) {
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

    /**
     * @param array<string, mixed> $data
     * @return User
     */
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