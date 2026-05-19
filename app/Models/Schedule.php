<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    protected $table = 'schedule';

    protected $fillable = [
        'nama_vaksin',
        'batch_kandang',
        'tanggal_target',
        'metode_pemberian',
        'status',
        'tanggal_selesai',
        'catatan',
    ];

    protected $casts = [
        'tanggal_target'  => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function getStatusAutoAttribute(): string
    {
        if ($this->status === 'SELESAI') {
            return 'SELESAI';
        }

        if ($this->tanggal_target < Carbon::today()) {
            return 'TERLEWAT';
        }

        return 'TERJADWAL';
    }

    public function scopeMendatang($query)
    {
        return $query->where('status', '!=', 'SELESAI')
                     ->orderBy('tanggal_target', 'asc');
    }
}
