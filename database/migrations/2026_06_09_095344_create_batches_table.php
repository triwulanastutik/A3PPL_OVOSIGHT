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
            $table->string('id_kandang')->unique();
            $table->date('tanggal_masuk');
            $table->integer('populasi');
            $table->enum('status_produksi', [
                'Produktif',
                'Afkir'
            ])->default('Produktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};