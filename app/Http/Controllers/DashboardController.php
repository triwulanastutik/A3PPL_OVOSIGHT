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
        | DATA TELUR TERBARU UNTUK MONITOR REAL-TIME
        |--------------------------------------------------------------------------
        */
        $latestLog = SensorLog::orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | GRAFIK MINGGUAN DASHBOARD
        |--------------------------------------------------------------------------
        | Sumbu X = Senin sampai Minggu
        | Sumbu Y = jumlah telur
        | Dataset = Layak dan Tidak Layak
        */
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $weekLogs = SensorLog::whereBetween('tanggal', [
                $startOfWeek->toDateString(),
                $endOfWeek->toDateString(),
            ])
            ->get();

        $namaHari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        $chart = [];

        for ($i = 0; $i < 7; $i++) {
            $tanggal = $startOfWeek->copy()->addDays($i);
            $tanggalKey = $tanggal->toDateString();

            $logsHariIni = $weekLogs->filter(function ($log) use ($tanggalKey) {
                return Carbon::parse($log->tanggal)->toDateString() === $tanggalKey;
            });

            $chart[] = [
                'hari'  => $namaHari[$tanggal->dayOfWeekIso],
                'layak' => $logsHariIni->where('status', 'layak')->count(),
                'tidak' => $logsHariIni->where('status', 'tidak')->count(),
            ];
        }

        $chartLabels = collect($chart)->pluck('hari')->values();
        $chartLayak  = collect($chart)->pluck('layak')->values();
        $chartTidak  = collect($chart)->pluck('tidak')->values();

        return view('dashboard', compact(
            'latestLog',
            'chartLabels',
            'chartLayak',
            'chartTidak'
        ));
    }
}
