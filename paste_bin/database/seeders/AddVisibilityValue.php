<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddVisibilityValue extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('visibilities')->insert([
            ['name' => 'public'],
            ['name' => 'private'],
            ['name' => 'unlisted'],
        ]);
    }
}
