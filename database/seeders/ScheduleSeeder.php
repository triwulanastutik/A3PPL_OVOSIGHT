<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jadwals = [
            [
                'nama_vaksin'      => 'IBD Gumboro',
                'batch_kandang'    => 'Batch 22-A (Kandang 1)',
                'tanggal_target'   => Carbon::create(2023, 10, 8),
                'metode_pemberian' => 'Air Minum',
                'status'           => 'TERLEWAT',
            ],
            [
                'nama_vaksin'      => 'ND-IB Boost',
                'batch_kandang'    => 'Batch 22-C (Kandang 3)',
                'tanggal_target'   => Carbon::create(2023, 10, 12),
                'metode_pemberian' => 'Air Minum',
                'status'           => 'TERJADWAL',
            ],
            [
                'nama_vaksin'      => 'Fowl Pox',
                'batch_kandang'    => 'Batch 21-D (Kandang 2)',
                'tanggal_target'   => Carbon::create(2023, 10, 5),
                'metode_pemberian' => 'Suntik',
                'status'           => 'SELESAI',
                'tanggal_selesai'  => Carbon::create(2023, 10, 5),
            ],
            [
                'nama_vaksin'      => 'AI (Flu Burung)',
                'batch_kandang'    => 'Batch 23-B (Brooder)',
                'tanggal_target'   => Carbon::create(2023, 10, 15),
                'metode_pemberian' => 'Suntik',
                'status'           => 'TERJADWAL',
            ],
            [
                'nama_vaksin'      => 'ND La Sota',
                'batch_kandang'    => 'Batch 22-A (Kandang 1)',
                'tanggal_target'   => Carbon::now()->addDays(5),
                'metode_pemberian' => 'Tetes Mata',
                'status'           => 'TERJADWAL',
            ],
            [
                'nama_vaksin'      => 'Marek',
                'batch_kandang'    => 'Batch 23-A (Brooder)',
                'tanggal_target'   => Carbon::now()->addDays(10),
                'metode_pemberian' => 'Suntik',
                'status'           => 'TERJADWAL',
            ],
        ];

        foreach ($jadwals as $data) {
            Schedule::create($data);
        }
    }
}
