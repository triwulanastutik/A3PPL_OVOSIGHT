<?php

namespace App\Http\Controllers;

use App\Models\SensorLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->input('range', '7d');

        $query = SensorLog::query();

        if ($range === '7d') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($range === '30d') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        } elseif ($range === '1y') {
            $query->where('created_at', '>=', Carbon::now()->subYear());
        }

        $latestLogs = (clone $query)->latest()->take(10)->get();

        $totalTelur     = (clone $query)->sum('units');
        $totalTidakLayak = (clone $query)->where('status', '!=', 'PRODUKTIF')->sum('units');
        $totalLayak     = $totalTelur - $totalTidakLayak;
        $persenLayak    = $totalTelur > 0 ? round(($totalLayak / $totalTelur) * 100, 2) : 0;

        // TODAY stats untuk card IoT
        $todayTotal = SensorLog::whereDate('created_at', today())->sum('units');

        $yesterdayTotal = SensorLog::whereDate('created_at', Carbon::yesterday())->sum('units');
        $trendPercent = $yesterdayTotal > 0
            ? round((($todayTotal - $yesterdayTotal) / $yesterdayTotal) * 100, 1)
            : 0;

        // Chart
        $chart = (clone $query)
            ->selectRaw("
                DATE(created_at) as label,
                SUM(units) as total,
                SUM(CASE WHEN status = 'PRODUKTIF' THEN units ELSE 0 END) as layak,
                SUM(CASE WHEN status != 'PRODUKTIF' THEN units ELSE 0 END) as tidak
            ")
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        return view('dashboard', compact(
            'latestLogs',
            'totalTelur',
            'totalLayak',
            'totalTidakLayak',
            'persenLayak',
            'chart',
            'range',
            'todayTotal',
            'trendPercent'
        ));
    }
}
