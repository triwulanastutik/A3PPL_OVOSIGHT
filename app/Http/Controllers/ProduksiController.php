<?php

namespace App\Http\Controllers;

use App\Models\SensorLog;

class ProduksiController extends Controller
{
    public function index()
    {
        $logs = SensorLog::latest()->get();

        return view('produksi.index', compact('logs'));
    }
}