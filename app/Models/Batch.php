<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Batch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'batches';

    protected $fillable = [
        'id_kandang',
        'tanggal_masuk',
        'populasi',
        'status_produksi',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'deleted_at' => 'datetime',
    ];

    public function getUmurMingguAttribute(): int
    {
        if (!$this->tanggal_masuk) {
            return 0;
        }

        return Carbon::parse($this->tanggal_masuk)->diffInWeeks(Carbon::today());
    }
}