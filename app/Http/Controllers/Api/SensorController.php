<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SensorLog;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    // Endpoint untuk ESP32 kirim data
    public function store(Request $request)
    {
        $request->validate([
            'sensor_id'  => 'required|string',
            'batch'      => 'required|string',
            'berat'      => 'required|numeric',
            'ir'         => 'required|integer',
            'units'      => 'required|integer',
            'status'     => 'required|in:PRODUKTIF,PERINGATAN,WASPADA',
        ]);

        $log = SensorLog::create([
            'sensor_id' => $request->sensor_id,
            'batch'     => $request->batch,
            'berat'     => $request->berat,
            'ir'        => $request->ir,
            'units'     => $request->units,
            'status'    => $request->status,
            'waktu'     => now(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => $log,
        ], 201);
    }

    // Endpoint polling untuk dashboard real-time
    public function latest()
    {
        $latest = SensorLog::latest()->take(10)->get();

        $todayTotal    = SensorLog::whereDate('created_at', today())->sum('units');
        $todayLayak    = SensorLog::whereDate('created_at', today())->where('status', 'PRODUKTIF')->sum('units');
        $todayTidak    = SensorLog::whereDate('created_at', today())->whereIn('status', ['PERINGATAN', 'WASPADA'])->sum('units');

        $lastLog = SensorLog::latest()->first();

        return response()->json([
            'logs'        => $latest,
            'todayTotal'  => $todayTotal,
            'todayLayak'  => $todayLayak,
            'todayTidak'  => $todayTidak,
            'lastLog'     => $lastLog,
        ]);
    }
}
