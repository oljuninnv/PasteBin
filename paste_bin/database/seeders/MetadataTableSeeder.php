<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetadataTableSeeder extends Seeder
{
    public function run()
    {
        // Получаем все paste из таблицы pastes
        $pastes = DB::table('pastes')->pluck('id')->toArray();

        // Проходим по всем paste и создаем записи в таблице metadata
        foreach ($pastes as $pasteId) {
            DB::table('metadata')->insert([
                'paste_id' => $pasteId,
                'views' => 0, // Значение по умолчанию
                'likes' => 0, // Значение по умолчанию
                'dislikes' => 0, // Значение по умолчанию
                'reports' => 0, // Значение по умолчанию
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
