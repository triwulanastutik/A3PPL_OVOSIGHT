<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;

class BatchSeeder extends Seeder
{
    public function run(): void
    {
        Batch::create([
            'kode_batch' => 'A001',
            'kandang' => 'Kandang A',
            'jenis_ayam' => 'ISA Brown',
            'tanggal_masuk' => '2025-01-01',
            'umur_minggu' => 25,
            'populasi' => 2500,
            'status_produksi' => 'Produktif'
        ]);

        Batch::create([
            'kode_batch' => 'B001',
            'kandang' => 'Kandang B',
            'jenis_ayam' => 'Lohmann',
            'tanggal_masuk' => '2024-01-01',
            'umur_minggu' => 75,
            'populasi' => 1800,
            'status_produksi' => 'Mendekati Afkir'
        ]);

        Batch::create([
            'kode_batch' => 'C001',
            'kandang' => 'Kandang C',
            'jenis_ayam' => 'Hy-Line',
            'tanggal_masuk' => '2023-01-01',
            'umur_minggu' => 85,
            'populasi' => 1500,
            'status_produksi' => 'Afkir'
        ]);
    }
}