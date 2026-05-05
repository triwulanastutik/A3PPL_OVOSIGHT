<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorLog;
use Carbon\Carbon;
use PDF;

class ProduksiController extends Controller
{
    public function index(Request $request)
    {
        // ===== DEFAULT RANGE =====
        $start = $request->start ?? now()->subDays(7)->format('Y-m-d');
        $end   = $request->end ?? now()->format('Y-m-d');

        $from = Carbon::parse($start)->startOfDay();
        $to   = Carbon::parse($end)->endOfDay();

        // ===== QUERY =====
        $logs = SensorLog::whereBetween('created_at', [$from, $to])->get();

        // ===== SUMMARY =====
        $total = $logs->sum('units');
        $layak = $logs->where('status','PRODUKTIF')->sum('units');
        $tidak = $logs->whereIn('status',['PERINGATAN','WASPADA'])->sum('units');

        $days = max($from->diffInDays($to), 1);
        $rata = round($total / $days);

        // ===== MODE DETEKSI =====
        $isYear = $days > 60;

        if ($isYear) {
            // BULANAN
            $chart = $logs->groupBy(fn($item) =>
                Carbon::parse($item->created_at)->format('Y-m')
            )->map(function ($group) {
                return [
                    'label' => Carbon::parse($group->first()->created_at)->format('M'),
                    'total' => $group->sum('units'),
                ];
            })->values();
        } else {
            // HARIAN
            $chart = $logs->groupBy(fn($item) =>
                Carbon::parse($item->created_at)->format('Y-m-d')
            )->map(function ($group) {
                return [
                    'label' => Carbon::parse($group->first()->created_at)->format('d M'),
                    'total' => $group->sum('units'),
                ];
            })->values();
        }

        // ===== TABLE =====
        $data = SensorLog::whereBetween('created_at', [$from, $to])
            ->latest()
            ->paginate(10);

        return view('produksi.index', compact(
            'total','layak','tidak','rata',
            'chart','data',
            'start','end'
        ));
    }

    public function exportPdf(Request $request)
    {
        $start = $request->start ?? now()->subDays(7)->format('Y-m-d');
        $end   = $request->end ?? now()->format('Y-m-d');

        $logs = SensorLog::whereBetween('created_at', [$start, $end])->get();

        $total = $logs->sum('units');
        $layak = $logs->where('status','PRODUKTIF')->sum('units');
        $tidak = $logs->whereIn('status',['PERINGATAN','WASPADA'])->sum('units');

        $pdf = PDF::loadView('pdf.produksi', compact(
            'logs','total','layak','tidak','start','end'
        ))->setPaper('A4','portrait');

        return $pdf->download("laporan-$start-$end.pdf");
    }
}