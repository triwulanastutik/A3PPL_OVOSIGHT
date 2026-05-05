<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SensorLogSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sensor_logs')->truncate();

        $data = [];
        $batchNo = 1;

        // Mulai dari 1 Maret 2026, setiap 2 hari ada beberapa batch
        $startDate = Carbon::create(2026, 3, 1, 8, 0, 0);

        for ($dayOffset = 0; $dayOffset <= 65; $dayOffset += 2) {
            $tanggal = $startDate->copy()->addDays($dayOffset);

            // 3-5 batch per sesi (per 2 hari)
            $batchCount = rand(3, 5);

            for ($i = 0; $i < $batchCount; $i++) {
                // Waktu per batch selisih beberapa menit
                $waktu = $tanggal->copy()->addMinutes($i * 15);

                $berat = rand(40, 72);
                $ir    = rand(60, 600);

                // Logika status sesuai alur OvoSight
                if ($berat < 45 || $berat > 70) {
                    $status = 'WASPADA';
                } elseif ($ir > 500) {
                    $status = 'PERINGATAN';
                } else {
                    $status = 'PRODUKTIF';
                }

                // Units: 1 per pengecekan batch
                $units = 1;

                $data[] = [
                    'sensor_id'  => 'SENSOR-1',
                    'batch'      => 'BATCH-' . str_pad($batchNo, 3, '0', STR_PAD_LEFT),
                    'berat'      => $berat,
                    'ir'         => $ir,
                    'units'      => $units,
                    'status'     => $status,
                    'waktu'      => $waktu,
                    'created_at' => $waktu,
                    'updated_at' => $waktu,
                ];

                $batchNo++;
            }
        }

        DB::table('sensor_logs')->insert($data);
    }
}
