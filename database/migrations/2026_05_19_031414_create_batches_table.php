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

            $table->string('kode_batch')->unique();

            $table->string('kandang');

            $table->string('jenis_ayam');

            $table->date('tanggal_masuk');

            $table->integer('umur_minggu');

            $table->integer('populasi');

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