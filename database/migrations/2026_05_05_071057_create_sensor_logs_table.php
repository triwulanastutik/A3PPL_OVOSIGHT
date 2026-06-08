<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();

            // ID telur, menggantikan sensor_id
            $table->string('id_telur')->unique();

            // Tanggal dan waktu pengecekan telur
            $table->date('tanggal');
            $table->time('waktu');

            // Data sensor
            $table->decimal('berat', 6, 2);
            $table->integer('cahaya');

            // Status klasifikasi telur
            $table->enum('status', ['layak', 'tidak']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
};