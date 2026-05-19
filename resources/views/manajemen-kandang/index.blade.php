<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Kandang</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 border-r border-slate-800 p-5">
        <h1 class="text-xl font-bold mb-6">OvoSight</h1>

        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-slate-800">
                Dashboard
            </a>

            <a href="{{ route('produksi') }}"
               class="block px-3 py-2 rounded hover:bg-slate-800">
                Produksi
            </a>

            <a href="{{ route('manajemen.kandang') }}"
               class="block bg-green-600 px-3 py-2 rounded">
                Manajemen Kandang
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-8">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">
                    Manajemen Kandang
                </h1>
                <p class="text-slate-400">
                    Pantau dan kelola populasi ayam berdasarkan batch
                </p>
            </div>

            <a href="{{ route('manajemen.kandang.create') }}"
               class="bg-green-600 px-4 py-2 rounded hover:bg-green-700">
                + Tambah Batch Ayam Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-slate-800 p-6 rounded-xl">

            <table class="w-full text-sm">

                <thead class="border-b border-slate-700 text-slate-400">
                    <tr>
                        <th class="text-left py-3">ID Batch</th>
                        <th class="text-left">Kandang</th>
                        <th class="text-left">Jenis</th>
                        <th class="text-left">Umur</th>
                        <th class="text-left">Populasi</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($batches as $batch)
                    <tr class="border-b border-slate-700">

                        <td class="py-3">
                            {{ $batch->kode_batch }}
                        </td>

                        <td>{{ $batch->kandang }}</td>

                        <td>{{ $batch->jenis_ayam }}</td>

                        <td>{{ $batch->umur_minggu }} Minggu</td>

                        <td>{{ number_format($batch->populasi) }}</td>

                        <td>
                            @if($batch->status_produksi == 'Produktif')
                                <span class="bg-green-600 px-2 py-1 rounded text-xs">
                                    Produktif
                                </span>
                            @elseif($batch->status_produksi == 'Mendekati Afkir')
                                <span class="bg-yellow-500 text-black px-2 py-1 rounded text-xs">
                                    Mendekati Afkir
                                </span>
                            @else
                                <span class="bg-red-600 px-2 py-1 rounded text-xs">
                                    Afkir
                                </span>
                            @endif
                        </td>

                        <td class="space-x-2">

                            <a href="{{ route('manajemen.kandang.edit', $batch->id) }}">
                                ✏️
                            </a>

                            <a href="{{ route('manajemen.kandang.show', $batch->id) }}">
                                👁️
                            </a>

                            <form action="{{ route('manajemen.kandang.destroy', $batch->id) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Yakin hapus data?')">
                                    🗑️
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7"
                            class="text-center py-5 text-slate-400">
                            Tidak ada data batch
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>

    </main>
</div>

</body>
</html>