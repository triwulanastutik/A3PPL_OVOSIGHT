<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SensorLogSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        // simulasi 30 hari ke belakang
        for ($day = 30; $day >= 0; $day--) {

            // setiap hari ada beberapa batch
            for ($i = 0; $i < rand(3, 6); $i++) {

                $tanggal = Carbon::now()->subDays($day);

                // logika realistis
                $berat = rand(40, 70);
                $ir = rand(80, 150);

                // tentukan status berdasarkan kondisi (bukan random)
                if ($berat >= 55 && $ir >= 110) {
                    $status = 'PRODUKTIF';
                    $units = rand(50, 150);
                } elseif ($berat >= 50) {
                    $status = 'PERINGATAN';
                    $units = rand(20, 60);
                } else {
                    $status = 'WASPADA';
                    $units = rand(5, 25);
                }

                $data[] = [
                    'sensor_id' => 'SENSOR-' . rand(1, 3),
                    'batch' => 'BATCH-' . rand(100, 999),
                    'berat' => $berat,
                    'ir' => $ir,
                    'units' => $units,
                    'status' => $status,
                    'waktu' => $tanggal,
                    'created_at' => $tanggal,
                    'updated_at' => $tanggal,
                ];
            }
        }

        DB::table('sensor_logs')->insert($data);
    }
}