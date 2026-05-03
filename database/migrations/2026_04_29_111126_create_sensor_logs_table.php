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
            $table->string('sensor_id');
            $table->string('batch');
            $table->integer('jumlah_telur');
            $table->enum('status', ['layak', 'tidak_layak']);
            $table->timestamp('waktu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
};