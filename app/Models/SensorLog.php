<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
    protected $table = 'sensor_logs';

    protected $fillable = [
        'id_kandang',
        'tanggal',
        'waktu',
        'berat',
        'cahaya',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'berat' => 'float',
        'cahaya' => 'integer',
    ];
}