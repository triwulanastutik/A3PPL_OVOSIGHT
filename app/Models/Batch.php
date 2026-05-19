<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $table = 'batches';

    protected $fillable = [
        'kode_batch',
        'kandang',
        'jenis_ayam',
        'tanggal_masuk',
        'umur_minggu',
        'populasi',
        'status_produksi'
    ];
}