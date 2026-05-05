<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
    protected $fillable = [
        'sensor_id',
        'batch',
        'berat',
        'ir',
        'units',
        'status',
        'waktu'
    ];
}
