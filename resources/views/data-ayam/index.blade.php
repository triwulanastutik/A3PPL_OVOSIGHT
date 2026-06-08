<!DOCTYPE html>
<html>
<head>
    <title>Data Ayam</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white">

@php
    $items = $batches instanceof \Illuminate\Pagination\AbstractPaginator
        ? collect($batches->items())
        : collect($batches);

    $totalKandang = $items->count();
    $totalPopulasi = $items->sum('populasi');
    $totalProduktif = $items->where('status_produksi', 'Produktif')->count();
    $totalAfkir = $items->where('status_produksi', 'Afkir')->count();
@endphp

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-60 bg-slate-950 text-white flex flex-col shrink-0">

        <div class="px-5 py-5 border-b border-slate-800">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center text-sm font-bold">
                    O
                </div>
                <span class="font-bold text-lg tracking-tight">OvoSight</span>
            </div>
        </div>

        <div class="px-5 py-3 border-b border-slate-800">
            <p class="text-xs text-slate-400 uppercase tracking-widest">Farm</p>
            <p class="font-semibold text-sm mt-0.5">Lubada Farm</p>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-0.5">
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800">
                Dashboard
            </a>

            <a href="{{ route('produksi') }}"
               class="flex items-center px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800">
                Produksi
            </a>

            <a href="{{ route('data.ayam') }}"
               class="flex items-center px-3 py-2.5 rounded-lg text-sm bg-green-600 text-white font-medium">
                Data Ayam
            </a>

            <a href="{{ route('jadwal.vaksinasi') }}"
               class="flex items-center px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800">
                Jadwal Vaksinasi
            </a>
        </nav>

        <div class="px-3 py-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-red-400 hover:bg-slate-800">
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    {{-- MAIN --}}
    <main class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-slate-950 border-b border-slate-800 px-6 py-3 flex items-center justify-between shrink-0">
            <div>
                <span class="font-semibold text-white">Lubada Farm</span>
            </div>

            <div class="flex items-center gap-2">
                <div class="text-right">
                    <p class="text-sm font-semibold text-white leading-none">
                        {{ auth()->user()->name ?? 'Admin OvoSight' }}
                    </p>
                    <p class="text-xs text-slate-400">OWNER</p>
                </div>

                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="p-5">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Data Ayam</h1>
                    <p class="text-slate-400 text-sm mt-1">
                        Pantau populasi, umur, jenis ayam, dan status produksi per kandang.
                    </p>
                </div>

                <a href="{{ route('data.ayam.create') }}"
                   class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-white text-sm font-semibold">
                    + Tambah Data Ayam
                </a>
            </div>

            {{-- ALERT --}}
            @if(session('success'))
                <div class="bg-green-700/30 border border-green-600 text-green-200 p-3 rounded-lg mb-5 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- SUMMARY --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-slate-800 p-4 rounded-xl border border-slate-700">
                    <p class="text-xs text-slate-400">Total Kandang</p>
                    <h2 class="text-2xl font-bold mt-1">{{ number_format($totalKandang) }}</h2>
                </div>

                <div class="bg-slate-800 p-4 rounded-xl border border-slate-700">
                    <p class="text-xs text-slate-400">Total Populasi</p>
                    <h2 class="text-2xl font-bold text-blue-400 mt-1">{{ number_format($totalPopulasi) }}</h2>
                </div>

                <div class="bg-slate-800 p-4 rounded-xl border border-slate-700">
                    <p class="text-xs text-slate-400">Produktif</p>
                    <h2 class="text-2xl font-bold text-green-400 mt-1">{{ number_format($totalProduktif) }}</h2>
                </div>

                <div class="bg-slate-800 p-4 rounded-xl border border-slate-700">
                    <p class="text-xs text-slate-400">Afkir</p>
                    <h2 class="text-2xl font-bold text-red-400 mt-1">{{ number_format($totalAfkir) }}</h2>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="bg-slate-800 p-5 rounded-xl border border-slate-700 mb-6">
                <form method="GET" action="{{ route('data.ayam') }}"
                      class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

                    <div class="md:col-span-2">
                        <label class="block text-xs text-slate-400 mb-1">Pencarian</label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari ID kandang, jenis, atau status..."
                               class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Jenis Ayam</label>
                        <select name="jenis_ayam"
                                class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Jenis</option>
                            <option value="kampung" {{ request('jenis_ayam') === 'kampung' ? 'selected' : '' }}>Kampung</option>
                            <option value="negeri" {{ request('jenis_ayam') === 'negeri' ? 'selected' : '' }}>Negeri</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Status</label>
                        <select name="status_produksi"
                                class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Status</option>
                            <option value="Produktif" {{ request('status_produksi') === 'Produktif' ? 'selected' : '' }}>Produktif</option>
                            <option value="Mendekati Afkir" {{ request('status_produksi') === 'Mendekati Afkir' ? 'selected' : '' }}>Mendekati Afkir</option>
                            <option value="Afkir" {{ request('status_produksi') === 'Afkir' ? 'selected' : '' }}>Afkir</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold w-full">
                            Filter
                        </button>

                        <a href="{{ route('data.ayam') }}"
                           class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden">

                <div class="px-5 py-4 border-b border-slate-700 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold">Daftar Data Ayam</h2>
                        <p class="text-xs text-slate-400 mt-1">
                            Umur ayam dihitung otomatis dari tanggal masuk.
                        </p>
                    </div>

                    <p class="text-xs text-slate-400">
                        Total tampil:
                        <span class="text-white font-semibold">{{ number_format($totalKandang) }}</span>
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">

                        <thead class="bg-slate-900 text-slate-400 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">ID Kandang</th>
                                <th class="px-4 py-3">Jenis</th>
                                <th class="px-4 py-3">Tanggal Masuk</th>
                                <th class="px-4 py-3">Umur</th>
                                <th class="px-4 py-3">Populasi</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($batches as $batch)
                                <tr class="border-t border-slate-700 hover:bg-slate-700/40">

                                    <td class="px-4 py-3 font-semibold text-white">
                                        {{ $batch->id_kandang }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                            {{ $batch->jenis_ayam === 'kampung'
                                                ? 'bg-yellow-500/20 text-yellow-300'
                                                : 'bg-blue-500/20 text-blue-300' }}">
                                            {{ $batch->jenis_ayam === 'kampung' ? 'Kampung' : 'Negeri' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-slate-300">
                                        {{ \Carbon\Carbon::parse($batch->tanggal_masuk)->format('d M Y') }}
                                    </td>

                                    <td class="px-4 py-3 text-yellow-400 font-semibold">
                                        {{ $batch->umur_minggu }} minggu
                                    </td>

                                    <td class="px-4 py-3 text-slate-300">
                                        {{ number_format($batch->populasi) }} ekor
                                    </td>

                                    <td class="px-4 py-3">
                                        @if($batch->status_produksi === 'Produktif')
                                            <span class="bg-green-600 px-3 py-1 rounded-full text-xs font-semibold text-white">
                                                Produktif
                                            </span>
                                        @elseif($batch->status_produksi === 'Mendekati Afkir')
                                            <span class="bg-yellow-500 px-3 py-1 rounded-full text-xs font-semibold text-black">
                                                Mendekati Afkir
                                            </span>
                                        @else
                                            <span class="bg-red-600 px-3 py-1 rounded-full text-xs font-semibold text-white">
                                                Afkir
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('data.ayam.edit', $batch->id) }}"
                                               class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-300 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Edit
                                            </a>

                                            <form action="{{ route('data.ayam.destroy', $batch->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus data ayam ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="bg-red-500/20 hover:bg-red-500/30 text-red-300 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                                        Tidak ada data ayam yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                @if(method_exists($batches, 'links'))
                    <div class="px-5 py-4 border-t border-slate-700">
                        {{ $batches->links() }}
                    </div>
                @endif

            </div>

        </div>
    </main>
</div>

</body>
</html>
