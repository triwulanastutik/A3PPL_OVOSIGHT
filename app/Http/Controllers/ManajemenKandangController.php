<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use Carbon\Carbon;

class ManajemenKandangController extends Controller
{
    public function index()
    {
        $batches = Batch::orderBy('created_at', 'desc')->get();

        foreach ($batches as $batch) {
            $statusTerbaru = $this->getStatus($batch->umur_minggu);

            if ($batch->status_produksi !== $statusTerbaru) {
                $batch->update([
                    'status_produksi' => $statusTerbaru,
                ]);
            }
        }

        return view('manajemen-kandang.index', compact('batches'));
    }

    public function create()
    {
        return view('manajemen-kandang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kandang'    => 'required|string|max:255|unique:batches,id_kandang',
            'tanggal_masuk' => 'required|date',
            'populasi'      => 'required|integer|min:1',
        ]);

        $umurMinggu = Carbon::parse($request->tanggal_masuk)
            ->diffInWeeks(Carbon::today());

        Batch::create([
            'id_kandang'      => $request->id_kandang,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'populasi'        => $request->populasi,
            'status_produksi' => $this->getStatus($umurMinggu),
        ]);

        return redirect()
            ->route('manajemen.kandang')
            ->with('success', 'Data kandang berhasil ditambahkan');
    }

    public function show($id)
    {
        $batch = Batch::findOrFail($id);

        $statusTerbaru = $this->getStatus($batch->umur_minggu);

        if ($batch->status_produksi !== $statusTerbaru) {
            $batch->update([
                'status_produksi' => $statusTerbaru,
            ]);

            $batch->status_produksi = $statusTerbaru;
        }

        return view('manajemen-kandang.show', compact('batch'));
    }

    public function edit($id)
    {
        $batch = Batch::findOrFail($id);

        return view('manajemen-kandang.edit', compact('batch'));
    }

    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);

        $request->validate([
            'id_kandang'    => 'required|string|max:255|unique:batches,id_kandang,' . $batch->id,
            'tanggal_masuk' => 'required|date',
            'populasi'      => 'required|integer|min:1',
        ]);

        $umurMinggu = Carbon::parse($request->tanggal_masuk)
            ->diffInWeeks(Carbon::today());

        $batch->update([
            'id_kandang'      => $request->id_kandang,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'populasi'        => $request->populasi,
            'status_produksi' => $this->getStatus($umurMinggu),
        ]);

        return redirect()
            ->route('manajemen.kandang')
            ->with('success', 'Data kandang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $batch = Batch::findOrFail($id);
        $batch->delete();

        return redirect()
            ->route('manajemen.kandang')
            ->with('success', 'Data kandang berhasil dihapus');
    }

    private function getStatus($umurMinggu)
    {
        if ($umurMinggu <= 100) {
            return 'Produktif';
        }

        return 'Afkir';
    }
}