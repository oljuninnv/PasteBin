<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('languages')->insert([
            ['id' => 1, 'name' => 'None', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'JavaScript', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Java', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'C#', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'C++', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'PHP', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Ruby', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Go', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Swift', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Python', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Rust', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'TypeScript', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'Dart', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'Scala', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Elixir', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Perl', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Lua', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Haskell', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Kotkin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Objective-C', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'Visual Basic .NET', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'F#', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'COBOL', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'Assembly', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'name' => 'Scratch', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'name' => 'Solidity', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'name' => 'Crystal', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'name' => 'Nim', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'name' => 'Elm', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'name' => 'Clojure', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}