<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Создаем 10 пользователей
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => bcrypt('User ' . $i), // Хешируем пароль с именем пользователя
                'email_verified_at' => $i <= 5 ? null : now(), // Первые 5 пользователей без подтверждения email
                'avatar' => 'users/default.png', // Устанавливаем аватар по умолчанию
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
