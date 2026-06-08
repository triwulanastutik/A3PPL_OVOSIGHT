<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';

    protected $fillable = [
        'nama_vaksin',
        'kandang',
        'tanggal',
        'metode_pemberian',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}