<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

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
        'deleted_at' => 'datetime',
    ];
}