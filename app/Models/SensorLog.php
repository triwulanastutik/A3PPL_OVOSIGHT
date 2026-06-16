<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
    protected $fillable = [
        'id_telur',
        'tanggal',
        'waktu',
        'berat',
        'cahaya',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'berat' => 'float',
    ];
}
