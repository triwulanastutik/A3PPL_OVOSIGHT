<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Batch extends Model
{
    use HasFactory;

    protected $table = 'batches';

    protected $fillable = [ 
        'id_kandang',
        'tanggal_masuk',
        'populasi',
        'status_produksi',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function getUmurMingguAttribute(): int
    {
        if (!$this->tanggal_masuk) {
            return 0;
        }

        return Carbon::parse($this->tanggal_masuk)->diffInWeeks(Carbon::today());
    }
}
