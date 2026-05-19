<!DOCTYPE html>
<html>
<head>
    <title>Tambah Batch Ayam</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white">

<div class="max-w-3xl mx-auto p-8">

    <h1 class="text-3xl font-bold mb-6">
        Tambah Batch Ayam
    </h1>

    <form action="{{ route('manajemen.kandang.store') }}"
          method="POST"
          class="bg-slate-800 p-6 rounded-xl space-y-4">

        @csrf

        <div>
            <label>ID Batch</label>
            <input type="text"
                   name="kode_batch"
                   class="w-full p-2 rounded bg-slate-700 mt-1">
        </div>

        <div>
            <label>Kandang</label>
            <input type="text"
                   name="kandang"
                   class="w-full p-2 rounded bg-slate-700 mt-1">
        </div>

        <div>
            <label>Jenis Ayam</label>
            <input type="text"
                   name="jenis_ayam"
                   class="w-full p-2 rounded bg-slate-700 mt-1">
        </div>

        <div>
            <label>Tanggal Masuk</label>
            <input type="date"
                   name="tanggal_masuk"
                   class="w-full p-2 rounded bg-slate-700 mt-1">
        </div>

        <div>
            <label>Umur (minggu)</label>
            <input type="number"
                   name="umur_minggu"
                   class="w-full p-2 rounded bg-slate-700 mt-1">
        </div>

        <div>
            <label>Populasi</label>
            <input type="number"
                   name="populasi"
                   class="w-full p-2 rounded bg-slate-700 mt-1">
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-green-600 px-4 py-2 rounded">
                Simpan
            </button>

            <a href="{{ route('manajemen.kandang') }}"
               class="bg-slate-600 px-4 py-2 rounded">
                Kembali
            </a>
        </div>

    </form>
</div>

</body>
</html>