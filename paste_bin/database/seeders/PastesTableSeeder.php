<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PastesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Получаем все категории и языки
        $categories = DB::table('categories')->pluck('id')->toArray();
        $languages = DB::table('languages')->pluck('id')->toArray();
        $users = DB::table('users')->pluck('id')->toArray(); 
        $visibilityOptions = DB::table('visibilities')->pluck('id')->toArray();
        $expirationOptions = DB::table('expiration_times')->pluck('id')->toArray(); 

        // Создаем 10 записей в таблице pastes
        for ($i = 1; $i <= 10; $i++) {
            $shortLink = Str::random(15); // Генерируем случайный хэш для короткой ссылки

            // Устанавливаем user_id для каждого третьего paste
            $userId = ($i % 3 === 0) ? $users[array_rand($users)] : null; // Каждому третьему paste присваиваем случайного пользователя

            DB::table('pastes')->insert([
                'title' => 'Paste Title ' . $i,
                'content' => 'This is the content of paste ' . $i,
                'category_id' => $categories[array_rand($categories)], // Случайная категория
                'language_id' => $languages[array_rand($languages)], // Случайный язык
                'user_id' => $userId, // user_id для каждого третьего paste
                'visibility_id' => $visibilityOptions[array_rand($visibilityOptions)], // Случайная видимость
                'expiration_time_id' => $expirationOptions[array_rand($expirationOptions)], // Случайное время истечения
                'short_link' => $shortLink, // Уникальная короткая ссылка
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
