<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddExpirationTimesValue extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expiration_times')->insert([
            ['name' => '10min','value_in_minutes' => 10],
            ['name' => '1hour','value_in_minutes' => 60],
            ['name' => '3hours','value_in_minutes' => 180],
            ['name' => '1day','value_in_minutes' => 1440],
            ['name' => '1week','value_in_minutes' => 10080],
            ['name' => '1month','value_in_minutes' => 43200],
            ['name' => 'never','value_in_minutes' => 0],
        ]);
    }
}
