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
        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        | Jika start dan end kosong, tampilkan semua data produksi.
        | Jika start dan end diisi, tampilkan data sesuai rentang tanggal.
        */
        $start = $request->start;
        $end   = $request->end;

        $query = SensorLog::query();

        if ($start && $end) {
            $from = Carbon::parse($start)->toDateString();
            $to   = Carbon::parse($end)->toDateString();

            $query->whereBetween('tanggal', [$from, $to]);
        }

        /*
        |--------------------------------------------------------------------------
        | DATA PRODUKSI UNTUK SUMMARY DAN GRAFIK
        |--------------------------------------------------------------------------
        */
        $logs = (clone $query)
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY PRODUKSI
        |--------------------------------------------------------------------------
        | 1 baris sensor_logs = 1 telur.
        */
        $total = $logs->count();
        $layak = $logs->where('status', 'layak')->count();
        $tidak = $logs->where('status', 'tidak')->count();

        $persentaseLayak = $total > 0
            ? round(($layak / $total) * 100, 2)
            : 0;

        $persentaseTidak = $total > 0
            ? round(($tidak / $total) * 100, 2)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | RATA-RATA PRODUKSI PER HARI
        |--------------------------------------------------------------------------
        */
        if ($logs->count() > 0) {
            $tanggalAwal = Carbon::parse($logs->min('tanggal'));
            $tanggalAkhir = Carbon::parse($logs->max('tanggal'));
            $jumlahHari = max($tanggalAwal->diffInDays($tanggalAkhir) + 1, 1);
        } else {
            $jumlahHari = 1;
        }

        $rata = round($total / $jumlahHari);

        /*
        |--------------------------------------------------------------------------
        | GRAFIK PRODUKSI PER HARI
        |--------------------------------------------------------------------------
        | Sumbu X = tanggal produksi.
        | Sumbu Y = jumlah telur/butir.
        | Dataset = total telur, layak, tidak layak.
        */
        $chart = $logs->groupBy(function ($item) {
                return Carbon::parse($item->tanggal)->format('Y-m-d');
            })
            ->map(function ($group) {
                $tanggal = Carbon::parse($group->first()->tanggal);

                return [
                    'label'   => $tanggal->format('d M'),
                    'tanggal' => $tanggal->toDateString(),
                    'total'   => $group->count(),
                    'layak'   => $group->where('status', 'layak')->count(),
                    'tidak'   => $group->where('status', 'tidak')->count(),
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | TABEL RECORD PRODUKSI
        |--------------------------------------------------------------------------
        | Menampilkan detail data telur.
        */
        $dataQuery = SensorLog::query();

        if ($start && $end) {
            $dataQuery->whereBetween('tanggal', [$from, $to]);
        }

        $data = $dataQuery
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('produksi.index', compact(
            'total',
            'layak',
            'tidak',
            'rata',
            'persentaseLayak',
            'persentaseTidak',
            'chart',
            'data',
            'start',
            'end'
        ));
    }

    public function exportPdf(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL UNTUK PDF
        |--------------------------------------------------------------------------
        */
        $start = $request->start;
        $end   = $request->end;

        $query = SensorLog::query();

        if ($start && $end) {
            $from = Carbon::parse($start)->toDateString();
            $to   = Carbon::parse($end)->toDateString();

            $query->whereBetween('tanggal', [$from, $to]);
        }

        $logs = $query
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY PDF
        |--------------------------------------------------------------------------
        */
        $total = $logs->count();
        $layak = $logs->where('status', 'layak')->count();
        $tidak = $logs->where('status', 'tidak')->count();

        $persentaseLayak = $total > 0
            ? round(($layak / $total) * 100, 2)
            : 0;

        $persentaseTidak = $total > 0
            ? round(($tidak / $total) * 100, 2)
            : 0;

        $namaFile = ($start && $end)
            ? "laporan-produksi-$start-$end.pdf"
            : "laporan-produksi-semua-data.pdf";

        $pdf = PDF::loadView('pdf.produksi', compact(
            'logs',
            'total',
            'layak',
            'tidak',
            'persentaseLayak',
            'persentaseTidak',
            'start',
            'end'
        ))->setPaper('A4', 'portrait');

        return $pdf->download($namaFile);
    }
}