<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SensorLog;

class SensorLogSeeder extends Seeder
{
    public function run(): void
    {
        SensorLog::create([
            'sensor_id' => 'SN-001',
            'batch' => 'Batch A',
            'jumlah_telur' => 120,
            'status' => 'layak',
            'waktu' => now(),
        ]);

        SensorLog::create([
            'sensor_id' => 'SN-002',
            'batch' => 'Batch B',
            'jumlah_telur' => 80,
            'status' => 'tidak_layak',
            'waktu' => now(),
        ]);
    }
}