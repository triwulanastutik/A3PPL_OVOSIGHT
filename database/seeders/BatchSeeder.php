<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;

class BatchSeeder extends Seeder
{
    public function run(): void
    {
        Batch::query()->delete();

        Batch::create([
            'id_kandang' => 'KDG-001',
            'jenis_ayam' => 'ras_petelur',
            'tanggal_masuk' => '2025-01-01',
            'populasi' => 2500,
            'status_produksi' => 'Produktif',
        ]);

        Batch::create([
            'id_kandang' => 'KDG-002',
            'jenis_ayam' => 'ras_petelur',
            'tanggal_masuk' => '2024-01-01',
            'populasi' => 1800,
            'status_produksi' => 'Mendekati Afkir',
        ]);

        Batch::create([
            'id_kandang' => 'KDG-003',
            'jenis_ayam' => 'kampung',
            'tanggal_masuk' => '2023-01-01',
            'populasi' => 1500,
            'status_produksi' => 'Afkir',
        ]);
    }
}