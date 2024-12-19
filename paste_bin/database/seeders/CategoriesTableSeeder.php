<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'None', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Cryptocurrence', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Cybersecurity', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Fixit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Food', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Gaming', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Haiku', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Help', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'History', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Housing', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Jokes', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Legal', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'Money', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'Movies', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Music', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Pets', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Photo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Science', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Software', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Source Code', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'Spirit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'Sports', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'Travel', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'TV', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'name' => 'Writing', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
