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
            $table->string('nama_vaksin');
            $table->string('kandang');
            $table->date('tanggal');
            $table->string('metode_pemberian')->nullable();
            $table->enum('status', ['belum', 'sudah'])->default('belum');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule');
    }
};