<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;

class BatchSeeder extends Seeder
{
    public function run(): void
    {
        $batches = [
            [
                'id_kandang' => 'KDG-001',
                'tanggal_masuk' => '2025-01-01',
                'populasi' => 2500,
                'status_produksi' => 'Produktif',
            ],
            [
                'id_kandang' => 'KDG-002',
                'tanggal_masuk' => '2024-01-01',
                'populasi' => 1800,
                'status_produksi' => 'Produktif',
            ],
            [
                'id_kandang' => 'KDG-003',
                'tanggal_masuk' => '2023-01-01',
                'populasi' => 1500,
                'status_produksi' => 'Afkir',
            ],
        ];

        foreach ($batches as $data) {
            $batch = Batch::withTrashed()->updateOrCreate(
                ['id_kandang' => $data['id_kandang']],
                [
                    'tanggal_masuk' => $data['tanggal_masuk'],
                    'populasi' => $data['populasi'],
                    'status_produksi' => $data['status_produksi'],
                ]
            );

            if ($batch->trashed()) {
                $batch->restore();
            }
        }
    }
}