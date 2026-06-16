<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SensorLog;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function store(Request $request)
    {
        try {

            // VALIDASI (dibuat sedikit lebih fleksibel untuk ESP32)
            $request->validate([
                'id_telur' => 'required|string',
                'berat'    => 'required|numeric',
                'ir'       => 'required|integer',
                'status'   => 'required|string',
            ]);

            // SIMPAN KE SUPABASE
            $log = SensorLog::create([
                'id_telur' => $request->id_telur,
                'tanggal'  => now()->toDateString(),
                'waktu'    => now()->format('H:i:s'),
                'berat'    => $request->berat,
                'cahaya'   => $request->ir, // mapping ESP32 IR → Supabase cahaya
                'status'   => strtolower($request->status),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $log
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function latest()
    {
        try {

            $latest = SensorLog::orderBy('id', 'desc')->limit(10)->get();

            $todayTotal = SensorLog::whereDate('tanggal', now()->toDateString())->count();

            $todayLayak = SensorLog::whereDate('tanggal', now()->toDateString())
                ->where('status', 'layak')
                ->count();

            $todayTidak = SensorLog::whereDate('tanggal', now()->toDateString())
                ->where('status', 'tidak')
                ->count();

            $lastLog = SensorLog::orderBy('id', 'desc')->first();

            return response()->json([
                'success' => true,
                'logs' => $latest,
                'todayTotal' => $todayTotal,
                'todayLayak' => $todayLayak,
                'todayTidak' => $todayTidak,
                'lastLog' => $lastLog,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
