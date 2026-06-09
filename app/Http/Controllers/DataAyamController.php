<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use Carbon\Carbon;

class DataAyamController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST DATA AYAM
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS PRODUKSI OTOMATIS
        |--------------------------------------------------------------------------
        */
        $allBatches = Batch::all();

        foreach ($allBatches as $batch) {
            $statusTerbaru = $this->getStatus($batch->umur_minggu);

            if ($batch->status_produksi !== $statusTerbaru) {
                $batch->update([
                    'status_produksi' => $statusTerbaru,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH DAN FILTER
        |--------------------------------------------------------------------------
        */
        $query = Batch::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id_kandang', 'like', '%' . $search . '%')
                  ->orWhere('status_produksi', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status_produksi')) {
            $query->where('status_produksi', $request->status_produksi);
        }

        $batches = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('data-ayam.index', compact('batches'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH DATA AYAM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('data-ayam.create');
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA AYAM BARU
    |--------------------------------------------------------------------------
    */
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
            ->route('data.ayam')
            ->with('success', 'Data ayam berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL DATA AYAM
    |--------------------------------------------------------------------------
    */
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

        return view('data-ayam.show', compact('batch'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT DATA AYAM
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $batch = Batch::findOrFail($id);

        return view('data-ayam.edit', compact('batch'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA AYAM
    |--------------------------------------------------------------------------
    */
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
            ->route('data.ayam')
            ->with('success', 'Data ayam berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA AYAM
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $batch = Batch::findOrFail($id);
        $batch->delete();

        return redirect()
            ->route('data.ayam')
            ->with('success', 'Data ayam berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIC STATUS PRODUKSI
    |--------------------------------------------------------------------------
    | Produktif  : 0 - 100 minggu
    | Afkir      : > 100 minggu
    */
    private function getStatus($umurMinggu)
    {
        if ($umurMinggu <= 100) {
            return 'Produktif';
        }

        return 'Afkir';
    }
}
