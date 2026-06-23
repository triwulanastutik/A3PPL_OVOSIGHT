<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();

            // Menggunakan id_kandang, bukan id_telur
            // Karena data produksi lebih relevan dicatat berdasarkan kandang/batch
            $table->string('id_kandang', 255);

            // Tanggal dan waktu pengecekan telur
            $table->date('tanggal');
            $table->time('waktu');

            // Data sensor
            $table->decimal('berat', 6, 2);
            $table->integer('cahaya');

            // Status klasifikasi telur pakai varchar/string, bukan enum
            $table->string('status', 20);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
};