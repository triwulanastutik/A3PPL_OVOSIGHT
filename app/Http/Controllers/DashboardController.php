<?php

namespace App\Http\Controllers;

use App\Models\SensorLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATA TELUR TERBARU
        |--------------------------------------------------------------------------
        */
        $latestLog = SensorLog::orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | DATA HARI INI
        |--------------------------------------------------------------------------
        */
        $today = Carbon::today()->toDateString();

        $todayLogs = SensorLog::whereDate('tanggal', $today)->get();

        $totalTelur = $todayLogs->count();
        $totalLayak = $todayLogs->where('status', 'layak')->count();
        $totalTidak = $todayLogs->where('status', 'tidak')->count();

        /*
        |--------------------------------------------------------------------------
        | PERBANDINGAN DENGAN KEMARIN
        |--------------------------------------------------------------------------
        */
        $yesterday = Carbon::yesterday()->toDateString();

        $yesterdayTotal = SensorLog::whereDate('tanggal', $yesterday)->count();

        $trendJumlah = $totalTelur - $yesterdayTotal;

        $trendPercent = $yesterdayTotal > 0
            ? round((($totalTelur - $yesterdayTotal) / $yesterdayTotal) * 100, 1)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | PERSENTASE KLASIFIKASI
        |--------------------------------------------------------------------------
        */
        $persenLayak = $totalTelur > 0
            ? round(($totalLayak / $totalTelur) * 100, 2)
            : 0;

        $persenTidak = $totalTelur > 0
            ? round(($totalTidak / $totalTelur) * 100, 2)
            : 0;

        return view('dashboard', compact(
            'latestLog',
            'totalTelur',
            'totalLayak',
            'totalTidak',
            'persenLayak',
            'persenTidak',
            'yesterdayTotal',
            'trendJumlah',
            'trendPercent'
        ));
    }
}