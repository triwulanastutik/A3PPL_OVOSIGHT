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
            'id_telur' => 'required|string',
            'berat'    => 'required|numeric',
            'ir'       => 'required|integer',
            'status'   => 'required|string',
        ]);

        SensorLog::create([
            'id_telur' => $request->id_telur . '-' . uniqid(),
            'tanggal'  => now()->toDateString(),
            'waktu'    => now()->format('H:i:s'),
            'berat'    => $request->berat,
            'cahaya'   => $request->ir,
            'status'   => strtolower($request->status),
        ]);

        return response()->json(['ok' => true]);
    }

    public function latest()
    {
        $last = SensorLog::orderBy('id', 'desc')->first();

        if (!$last) {
            return response()->json([
                'success' => false,
                'message' => 'No data'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id_telur' => $last->id_telur, // ✅ Fix: pakai $last bukan $request
                'berat'    => $last->berat,
                'ir'       => $last->cahaya,
                'status'   => $last->status,
                'tanggal'  => $last->tanggal,
                'waktu'    => $last->waktu,
            ]
        ]);
    }
}
