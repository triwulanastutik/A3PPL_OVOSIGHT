<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        Schedule::withTrashed()->forceDelete();

        $jadwals = [
            [
                'nama_vaksin' => 'IBD Gumboro',
                'kandang' => 'KDG-001',
                'tanggal' => Carbon::now()->addDays(3)->toDateString(),
                'metode_pemberian' => 'Air Minum',
                'status' => 'belum',
                'catatan' => 'Vaksinasi awal untuk pencegahan Gumboro.',
            ],
            [
                'nama_vaksin' => 'ND-IB Boost',
                'kandang' => 'KDG-002',
                'tanggal' => Carbon::now()->addDays(7)->toDateString(),
                'metode_pemberian' => 'Air Minum',
                'status' => 'belum',
                'catatan' => 'Booster ND-IB.',
            ],
            [
                'nama_vaksin' => 'Fowl Pox',
                'kandang' => 'KDG-003',
                'tanggal' => Carbon::now()->subDays(5)->toDateString(),
                'metode_pemberian' => 'Suntik',
                'status' => 'sudah',
                'catatan' => 'Sudah dilakukan oleh petugas kandang.',
            ],
            [
                'nama_vaksin' => 'AI Flu Burung',
                'kandang' => 'KDG-001',
                'tanggal' => Carbon::now()->addDays(14)->toDateString(),
                'metode_pemberian' => 'Suntik',
                'status' => 'belum',
                'catatan' => 'Jadwal vaksin flu burung.',
            ],
        ];

        foreach ($jadwals as $data) {
            Schedule::create($data);
        }
    }
}