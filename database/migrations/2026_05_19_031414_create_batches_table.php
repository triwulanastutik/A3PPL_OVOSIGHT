<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();

            // Menggantikan kode_batch / id batch
            $table->string('id_kandang')->unique();

            // Jenis ayam untuk konteks peternakan ayam petelur
            $table->enum('jenis_ayam', ['kampung', 'ras_petelur']);

            // Dipakai untuk menghitung umur ayam otomatis setiap minggu
            $table->date('tanggal_masuk');

            // Jumlah ayam dalam kandang
            $table->integer('populasi')->nullable();

            // Status produksi ayam
            $table->enum('status_produksi', [
                'Produktif',
                'Mendekati Afkir',
                'Afkir'
            ])->default('Produktif');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};