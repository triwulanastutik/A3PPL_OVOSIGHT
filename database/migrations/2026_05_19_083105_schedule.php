<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();

            // Nama vaksin
            $table->string('nama_vaksin');

            // Input text, bukan dropdown
            $table->string('kandang');

            // Tanggal jadwal vaksinasi
            $table->date('tanggal');

            // Metode pemberian vaksin
            $table->string('metode_pemberian')->nullable();

            // Status vaksinasi
            $table->enum('status', ['belum', 'sudah'])->default('belum');

            // Catatan tambahan
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule');
    }
};