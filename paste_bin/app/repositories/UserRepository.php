<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findByName(string $name): ?User
    {
        return User::where('name', $name)->first();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function deleteTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}