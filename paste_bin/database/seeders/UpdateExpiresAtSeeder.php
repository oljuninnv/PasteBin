<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateExpiresAtSeeder extends Seeder
{
    public function run()
    {
        // Получаем все paste из таблицы pastes
        $pastes = DB::table('pastes')->get();

        foreach ($pastes as $paste) {
            $expirationTime = $paste->expiration_time;
            $expiresAt = null;

            // Устанавливаем expires_at в зависимости от expiration_time
            switch ($expirationTime) {
                case '10min':
                    $expiresAt = Carbon::now()->addMinutes(10);
                    break;
                case '1hour':
                    $expiresAt = Carbon::now()->addHours(1);
                    break;
                case '3hours':
                    $expiresAt = Carbon::now()->addHours(3);
                    break;
                case '1day':
                    $expiresAt = Carbon::now()->addDay();
                    break;
                case '1week':
                    $expiresAt = Carbon::now()->addWeek();
                    break;
                case '1month':
                    $expiresAt = Carbon::now()->addMonth();
                    break;
                case 'never':
                    $expiresAt = null; // Если 'never', expires_at остается null
                    break;
            }

            // Обновляем запись в таблице pastes
            DB::table('pastes')->where('id', $paste->id)->update([
                'expires_at' => $expiresAt,
                'updated_at' => now(),
            ]);
        }
    }
}