<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use RuntimeException;

class SensorLogSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sensor_logs')->delete();

        $idKandang = DB::table('batches')
            ->orderBy('id')
            ->value('id_kandang');

        if (!$idKandang) {
            throw new RuntimeException('Data batches belum ada. Jalankan BatchSeeder sebelum SensorLogSeeder.');
        }

        $data = [];

        $startDate = Carbon::create(2026, 3, 1, 8, 0, 0);

        for ($dayOffset = 0; $dayOffset <= 30; $dayOffset += 2) {
            $tanggal = $startDate->copy()->addDays($dayOffset);

            $jumlahPengecekan = rand(10, 30);

            for ($i = 0; $i < $jumlahPengecekan; $i++) {
                $waktu = $tanggal->copy()->addMinutes($i * 3);

                $berat = rand(40, 72);
                $cahaya = rand(60, 600);

                if ($berat >= 45 && $berat <= 70 && $cahaya <= 500) {
                    $status = 'layak';
                } else {
                    $status = 'tidak';
                }

                $data[] = [
                    'id_kandang' => $idKandang,
                    'tanggal'    => $waktu->toDateString(),
                    'waktu'      => $waktu->format('H:i:s'),
                    'berat'      => $berat,
                    'cahaya'     => $cahaya,
                    'status'     => $status,
                    'created_at' => $waktu,
                    'updated_at' => $waktu,
                ];
            }
        }

        DB::table('sensor_logs')->insert($data);
    }
}