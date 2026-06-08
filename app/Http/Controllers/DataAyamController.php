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
        | Status produksi dihitung dari umur ayam.
        | Umur ayam berasal dari tanggal_masuk dan accessor di model Batch.
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
                  ->orWhere('jenis_ayam', 'like', '%' . $search . '%')
                  ->orWhere('status_produksi', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('jenis_ayam')) {
            $query->where('jenis_ayam', $request->jenis_ayam);
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
            'jenis_ayam'    => 'required|in:kampung,negeri',
            'tanggal_masuk' => 'required|date',
            'populasi'      => 'required|integer|min:1',
        ]);

        $umurMinggu = Carbon::parse($request->tanggal_masuk)
            ->diffInWeeks(Carbon::today());

        Batch::create([
            'id_kandang'      => $request->id_kandang,
            'jenis_ayam'      => $request->jenis_ayam,
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
            'jenis_ayam'    => 'required|in:kampung,negeri',
            'tanggal_masuk' => 'required|date',
            'populasi'      => 'required|integer|min:1',
        ]);

        $umurMinggu = Carbon::parse($request->tanggal_masuk)
            ->diffInWeeks(Carbon::today());

        $batch->update([
            'id_kandang'      => $request->id_kandang,
            'jenis_ayam'      => $request->jenis_ayam,
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
    | Umur ayam dihitung otomatis dari tanggal_masuk.
    */
    private function getStatus($umurMinggu)
    {
        if ($umurMinggu < 75) {
            return 'Produktif';
        }

        if ($umurMinggu < 80) {
            return 'Mendekati Afkir';
        }

        return 'Afkir';
    }
}