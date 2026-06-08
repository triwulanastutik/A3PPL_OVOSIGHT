<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalVaksinasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN INDEX JADWAL VAKSINASI
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $bulan = (int) $request->input('bulan', Carbon::now()->month);
        $tahun = (int) $request->input('tahun', Carbon::now()->year);

        $currentMonth = Carbon::createFromDate($tahun, $bulan, 1);

        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK KALENDER
        |--------------------------------------------------------------------------
        */
        $jadwalBulanIni = Schedule::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('tanggal', 'asc')
            ->get()
            ->groupBy(function ($jadwal) {
                return Carbon::parse($jadwal->tanggal)->format('Y-m-d');
            });

        /*
        |--------------------------------------------------------------------------
        | STATUS TAMPILAN
        |--------------------------------------------------------------------------
        | Database hanya menyimpan:
        | - belum
        | - sudah
        |
        | Terlewat dihitung otomatis:
        | status = belum dan tanggal < hari ini
        */
        $jadwalMendatang = Schedule::where('status', 'belum')
            ->whereDate('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->get();

        $jadwalTerlewat = Schedule::where('status', 'belum')
            ->whereDate('tanggal', '<', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->get();

        $jadwalSelesai = Schedule::where('status', 'sudah')
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        return view('jadwal-vaksinasi.index', compact(
            'currentMonth',
            'jadwalBulanIni',
            'jadwalMendatang',
            'jadwalTerlewat',
            'jadwalSelesai',
            'bulan',
            'tahun'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH JADWAL
    |--------------------------------------------------------------------------
    */
    public function create(Request $request)
    {
        $tanggal = $request->tanggal;

        return view('jadwal-vaksinasi.create', compact('tanggal'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN JADWAL BARU
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'nama_vaksin'      => 'required|string|max:100',
            'kandang'          => 'required|string|max:100',
            'tanggal'          => 'required|date',
            'metode_pemberian' => 'nullable|string|max:50',
            'catatan'          => 'nullable|string',
        ]);

        $tanggal = Carbon::parse($request->tanggal);

        Schedule::create([
            'nama_vaksin'      => $request->nama_vaksin,
            'kandang'          => $request->kandang,
            'tanggal'          => $tanggal->toDateString(),
            'metode_pemberian' => $request->metode_pemberian,
            'status'           => 'belum',
            'catatan'          => $request->catatan,
        ]);

        return redirect()
            ->route('jadwal.vaksinasi', [
                'bulan' => $tanggal->month,
                'tahun' => $tanggal->year,
            ])
            ->with('success', 'Jadwal vaksinasi berhasil disimpan!');
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT JADWAL
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $jadwal = Schedule::findOrFail($id);

        return view('jadwal-vaksinasi.edit', compact('jadwal'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE JADWAL
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_vaksin'      => 'required|string|max:100',
            'kandang'          => 'required|string|max:100',
            'tanggal'          => 'required|date',
            'metode_pemberian' => 'nullable|string|max:50',
            'status'           => 'required|in:belum,sudah',
            'catatan'          => 'nullable|string',
        ]);

        $jadwal = Schedule::findOrFail($id);
        $tanggal = Carbon::parse($request->tanggal);

        $jadwal->update([
            'nama_vaksin'      => $request->nama_vaksin,
            'kandang'          => $request->kandang,
            'tanggal'          => $tanggal->toDateString(),
            'metode_pemberian' => $request->metode_pemberian,
            'status'           => $request->status,
            'catatan'          => $request->catatan,
        ]);

        return redirect()
            ->route('jadwal.vaksinasi', [
                'bulan' => $tanggal->month,
                'tahun' => $tanggal->year,
            ])
            ->with('success', 'Jadwal vaksinasi berhasil diperbarui!');
    }

    /*
    |--------------------------------------------------------------------------
    | TANDAI SELESAI
    |--------------------------------------------------------------------------
    */
    public function selesai($id)
    {
        $jadwal = Schedule::findOrFail($id);

        $jadwal->update([
            'status' => 'sudah',
        ]);

        return back()->with('success', 'Jadwal ditandai sudah selesai!');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS JADWAL
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}