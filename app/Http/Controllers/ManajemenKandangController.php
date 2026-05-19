<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;

class ManajemenKandangController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST DATA
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $batches = Batch::all();

        foreach ($batches as $batch) {
            $batch->status_produksi = $this->getStatus($batch->umur_minggu);
        }

        return view('manajemen-kandang.index', compact('batches'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('manajemen-kandang.create');
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA BARU
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'kode_batch'    => 'required|unique:batches',
            'kandang'       => 'required',
            'jenis_ayam'    => 'required',
            'tanggal_masuk' => 'required|date',
            'umur_minggu'   => 'required|integer',
            'populasi'      => 'required|integer'
        ]);

        Batch::create([
            'kode_batch'      => $request->kode_batch,
            'kandang'         => $request->kandang,
            'jenis_ayam'      => $request->jenis_ayam,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'umur_minggu'     => $request->umur_minggu,
            'populasi'        => $request->populasi,
            'status_produksi' => $this->getStatus($request->umur_minggu)
        ]);

        return redirect()
            ->route('manajemen.kandang')
            ->with('success', 'Batch berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL DATA
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $batch = Batch::findOrFail($id);

        $batch->status_produksi = $this->getStatus($batch->umur_minggu);

        return view('manajemen-kandang.show', compact('batch'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $batch = Batch::findOrFail($id);

        return view('manajemen-kandang.edit', compact('batch'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_batch'    => 'required|unique:batches,kode_batch,' . $id,
            'kandang'       => 'required',
            'jenis_ayam'    => 'required',
            'tanggal_masuk' => 'required|date',
            'umur_minggu'   => 'required|integer',
            'populasi'      => 'required|integer'
        ]);

        $batch = Batch::findOrFail($id);

        $batch->update([
            'kode_batch'      => $request->kode_batch,
            'kandang'         => $request->kandang,
            'jenis_ayam'      => $request->jenis_ayam,
            'tanggal_masuk'   => $request->tanggal_masuk,
            'umur_minggu'     => $request->umur_minggu,
            'populasi'        => $request->populasi,
            'status_produksi' => $this->getStatus($request->umur_minggu)
        ]);

        return redirect()
            ->route('manajemen.kandang')
            ->with('success', 'Batch berhasil diupdate');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE DATA
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $batch = Batch::findOrFail($id);

        $batch->delete();

        return redirect()
            ->route('manajemen.kandang')
            ->with('success', 'Batch berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIC STATUS
    |--------------------------------------------------------------------------
    */
    private function getStatus($umur)
    {
        if ($umur < 80) {
            return 'Produktif';
        } elseif ($umur < 100) {
            return 'Mendekati Afkir';
        }

        return 'Afkir';
    }
}
