<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SensorLog;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->get('range', '7d');

        // 🔥 Tentukan range
        switch ($range) {
            case '30d':
                $start = now()->subDays(29);
                break;
            case '1y':
                $start = now()->subYear();
                break;
            default:
                $start = now()->subDays(6);
                break;
        }

        // 🔥 TOTAL
        $totalTelur = SensorLog::sum('jumlah_telur');
        $totalLayak = SensorLog::where('status', 'layak')->sum('jumlah_telur');
        $totalTidakLayak = SensorLog::where('status', 'tidak_layak')->sum('jumlah_telur');

        $persenLayak = $totalTelur > 0
            ? round(($totalLayak / $totalTelur) * 100)
            : 0;

        // 🔥 QUERY CHART
        if ($range === '1y') {
            $rawChart = SensorLog::select(
                    DB::raw("TO_CHAR(waktu, 'YYYY-MM') as label"),
                    DB::raw("SUM(jumlah_telur) as total")
                )
                ->where('waktu', '>=', $start)
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            $chart = $rawChart; // untuk 1 tahun tidak perlu fill harian
        } else {
            $rawChart = SensorLog::select(
                    DB::raw("DATE(waktu) as label"),
                    DB::raw("SUM(jumlah_telur) as total")
                )
                ->where('waktu', '>=', $start)
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            // 🔥 Isi tanggal kosong (biar chart tidak bolong)
            $period = CarbonPeriod::create($start, now());

            $chart = collect($period)->map(function ($date) use ($rawChart) {
                $found = $rawChart->firstWhere('label', $date->format('Y-m-d'));

                return (object)[
                    'label' => $date->format('Y-m-d'),
                    'total' => $found->total ?? 0
                ];
            });
        }

        $latestLogs = SensorLog::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalTelur',
            'totalLayak',
            'totalTidakLayak',
            'persenLayak',
            'chart',
            'latestLogs',
            'range'
        ));
    }
}