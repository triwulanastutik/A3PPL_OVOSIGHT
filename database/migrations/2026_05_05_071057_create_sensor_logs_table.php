<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('sensor_id');
            $table->string('batch');
            $table->float('berat');
            $table->integer('ir');
            $table->integer('units');
            $table->enum('status', ['PRODUKTIF', 'PERINGATAN', 'WASPADA']);
            $table->timestamp('waktu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
};