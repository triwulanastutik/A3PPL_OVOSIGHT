<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalVaksinasiController extends Controller
{
    /**
     * Show calendar + form + sidebar list
     */
    public function index(Request $request)
    {
        // Auto-update TERLEWAT status for past-due schedules
        Schedule::where('status', 'TERJADWAL')
            ->where('tanggal_target', '<', Carbon::today())
            ->update(['status' => 'TERLEWAT']);

        // Month navigation
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $currentMonth = Carbon::createFromDate($tahun, $bulan, 1);

        // All schedules for this month (for calendar dots)
        $jadwalBulanIni = Schedule::whereYear('tanggal_target', $tahun)
            ->whereMonth('tanggal_target', $bulan)
            ->get()
            ->groupBy(fn($j) => $j->tanggal_target->format('Y-m-d'));

        // Sidebar: non-completed schedules, ordered by date
        $jadwalMendatang = Schedule::where('status', '!=', 'SELESAI')
            ->orderBy('tanggal_target', 'asc')
            ->get();

        // Completed schedules for sidebar
        $jadwalSelesai = Schedule::where('status', 'SELESAI')
            ->orderBy('tanggal_selesai', 'desc')
            ->take(5)
            ->get();

        // Edit mode: load specific schedule if edit_id passed
        $editJadwal = null;
        if ($request->has('edit_id')) {
            $editJadwal = Schedule::find($request->edit_id);
        }

        // Available batches (from batches table if exists, else dummy)
        $batches = $this->getBatches();

        return view('jadwal-vaksinasi.index', compact(
            'currentMonth',
            'jadwalBulanIni',
            'jadwalMendatang',
            'jadwalSelesai',
            'editJadwal',
            'batches',
            'bulan',
            'tahun'
        ));
    }

    /**
     * Store new schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_vaksin'      => 'required|string|max:100',
            'batch_kandang'    => 'required|string|max:50',
            'tanggal_target'   => 'required|date',
            'metode_pemberian' => 'required|string|max:50',
        ]);

        $tanggal = Carbon::parse($request->tanggal_target);
        $status  = $tanggal->isPast() && !$tanggal->isToday() ? 'TERLEWAT' : 'TERJADWAL';

        Schedule::create([
            'nama_vaksin'      => $request->nama_vaksin,
            'batch_kandang'    => $request->batch_kandang,
            'tanggal_target'   => $request->tanggal_target,
            'metode_pemberian' => $request->metode_pemberian,
            'status'           => $status,
            'catatan'          => $request->catatan,
        ]);

        return redirect()
            ->route('jadwal.vaksinasi', ['bulan' => $tanggal->month, 'tahun' => $tanggal->year])
            ->with('success', 'Jadwal vaksinasi berhasil disimpan!');
    }

    /**
     * Update existing schedule
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_vaksin'      => 'required|string|max:100',
            'batch_kandang'    => 'required|string|max:50',
            'tanggal_target'   => 'required|date',
            'metode_pemberian' => 'required|string|max:50',
        ]);

        $jadwal  = Schedule::findOrFail($id);
        $tanggal = Carbon::parse($request->tanggal_target);

        // Only update status if not already SELESAI
        $status = $jadwal->status === 'SELESAI'
            ? 'SELESAI'
            : ($tanggal->isPast() && !$tanggal->isToday() ? 'TERLEWAT' : 'TERJADWAL');

        $jadwal->update([
            'nama_vaksin'      => $request->nama_vaksin,
            'batch_kandang'    => $request->batch_kandang,
            'tanggal_target'   => $request->tanggal_target,
            'metode_pemberian' => $request->metode_pemberian,
            'status'           => $status,
            'catatan'          => $request->catatan,
        ]);

        return redirect()
            ->route('jadwal.vaksinasi', ['bulan' => $tanggal->month, 'tahun' => $tanggal->year])
            ->with('success', 'Jadwal vaksinasi berhasil diperbarui!');
    }

    /**
     * Mark as completed
     */
    public function selesai($id)
    {
        $jadwal = Schedule::findOrFail($id);
        $jadwal->update([
            'status'          => 'SELESAI',
            'tanggal_selesai' => Carbon::today(),
        ]);

        return back()->with('success', 'Jadwal ditandai sudah selesai!');
    }

    /**
     * Delete schedule
     */
    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Helper: get available batches
     */
    private function getBatches(): array
    {
        try {
            return \App\Models\Batch::all()
                ->map(fn($b) => $b->kode_batch . ' (' . $b->kandang . ')')
                ->toArray();
        } catch (\Exception $e) {
            return [
                'Batch 22-A (Kandang 1)',
                'Batch 22-B (Kandang 2)',
                'Batch 22-C (Kandang 3)',
                'Batch 22-D (Kandang 4)',
                'Batch 23-A (Brooder)',
                'Batch 23-B (Brooder)',
            ];
        }
    }
}
