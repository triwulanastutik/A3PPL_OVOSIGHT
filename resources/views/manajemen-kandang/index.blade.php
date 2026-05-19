<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Kandang</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white">

<div class="flex min-h-screen">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-60 bg-slate-950 text-white flex flex-col shrink-0">
        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-slate-800">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center text-sm font-bold">O</div>
                <span class="font-bold text-lg tracking-tight">OvoSight</span>
            </div>
        </div>

        {{-- Farm name --}}
        <div class="px-5 py-3 border-b border-slate-800">
            <p class="text-xs text-slate-400 uppercase tracking-widest">Farm</p>
            <p class="font-semibold text-sm mt-0.5">Lubada Farm</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('produksi') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Produksi
            </a>

            <a href="{{ route('manajemen.kandang') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm bg-green-600 text-white font-medium transition-all">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Manajemen Kandang
            </a>

            <a href="{{ route('jadwal.vaksinasi') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 font-medium transition-all">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Jadwal Vaksinasi
            </a>
        </nav>

        {{-- Bottom links --}}
        <div class="px-3 py-4 border-t border-slate-800 space-y-0.5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-red-400 hover:bg-slate-800 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-slate-950 border-b border-slate-800 px-6 py-3 flex items-center justify-between shrink-0">

            <div class="flex items-center gap-3">
                <span class="font-semibold text-white">
                    Lubada Farm
                </span>
            </div>

            <div class="flex items-center gap-3">

                <div class="relative">

                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>

                    <input type="text"
                        placeholder="Cari data..."
                        class="pl-9 pr-4 py-1.5 text-sm bg-slate-800 text-white rounded-lg border border-slate-700 focus:outline-none focus:ring-2 focus:ring-green-500 w-48 placeholder:text-slate-400"/>
                </div>

                <div class="flex items-center gap-2">

                    <div class="text-right">
                        <p class="text-sm font-semibold text-white leading-none">
                            Fauzan Lubada
                        </p>

                        <p class="text-xs text-slate-400">
                            OWNER
                        </p>
                    </div>

                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                        F
                    </div>
                </div>

            </div>
        </header>

        <div class="flex justify-between items-center mb-6 p-5">
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

                            {{-- <a href="{{ route('manajemen.kandang.show', $batch->id) }}">
                                👁️ --}}
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
