<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SensorLog;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_kandang' => 'required|string|max:255',
            'berat'      => 'required|numeric',
            'ir'         => 'required|integer',
            'status'     => 'required|string',
        ]);

        $status = strtolower($request->status);

        if (!in_array($status, ['layak', 'tidak'])) {
            return response()->json([
                'ok' => false,
                'message' => 'Status harus layak atau tidak',
            ], 422);
        }

        $sensorLog = SensorLog::create([
            'id_kandang' => $request->id_kandang,
            'tanggal'    => now()->toDateString(),
            'waktu'      => now()->format('H:i:s'),
            'berat'      => $request->berat,
            'cahaya'     => $request->ir,
            'status'     => $status,
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Data sensor berhasil disimpan',
            'data' => [
                'id'         => $sensorLog->id,
                'id_kandang' => $sensorLog->id_kandang,
                'berat'      => $sensorLog->berat,
                'ir'         => $sensorLog->cahaya,
                'status'     => $sensorLog->status,
                'tanggal'    => $sensorLog->tanggal,
                'waktu'      => $sensorLog->waktu,
            ],
        ]);
    }

    public function latest()
    {
        $last = SensorLog::orderBy('id', 'desc')->first();

        if (!$last) {
            return response()->json([
                'success' => false,
                'message' => 'No data',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id'         => $last->id,
                'id_kandang' => $last->id_kandang,
                'berat'      => $last->berat,
                'ir'         => $last->cahaya,
                'status'     => $last->status,
                'tanggal'    => $last->tanggal,
                'waktu'      => $last->waktu,
            ],
        ]);
    }
}