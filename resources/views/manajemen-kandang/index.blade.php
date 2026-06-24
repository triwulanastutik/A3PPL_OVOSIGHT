<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kandang</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white overflow-x-hidden">

<div id="sidebar-overlay"
     class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden"></div>

<div class="flex min-h-screen">

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar"
           class="fixed lg:static inset-y-0 left-0 z-50 w-64 lg:w-60 bg-slate-950 text-white flex flex-col shrink-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">

        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center text-sm font-bold">
                    O
                </div>
                <span class="font-bold text-lg tracking-tight">OvoSight</span>
            </div>

            <button type="button"
                    id="close-sidebar"
                    class="lg:hidden text-slate-400 hover:text-white text-2xl leading-none">
                &times;
            </button>
        </div>

        {{-- Farm name --}}
        <div class="px-5 py-3 border-b border-slate-800">
            <p class="text-xs text-slate-400 uppercase tracking-widest">Farm</p>
            <p class="font-semibold text-sm mt-0.5">Lubada Farm</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
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
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 w-full">

        {{-- TOPBAR --}}
        <header class="bg-slate-950 border-b border-slate-800 px-4 sm:px-6 py-3 flex items-center justify-between shrink-0">

            <div class="flex items-center gap-3 min-w-0">
                <button type="button"
                        id="open-sidebar"
                        class="lg:hidden w-9 h-9 rounded-lg bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-white">
                    ☰
                </button>

                <span class="font-semibold text-white truncate">
                    Lubada Farm
                </span>
            </div>

            <div class="flex items-center gap-3 shrink-0">

                <div class="relative hidden md:block">
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
                    <div class="text-right hidden sm:block">
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

        <div class="p-4 sm:p-5 min-w-0">

            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">
                        Manajemen Kandang
                    </h1>
                    <p class="text-slate-400 text-sm sm:text-base mt-1">
                        Pantau dan kelola populasi ayam berdasarkan batch
                    </p>
                </div>

                <a href="{{ route('manajemen.kandang.create') }}"
                   class="w-full md:w-auto text-center bg-green-600 px-4 py-2 rounded hover:bg-green-700 text-sm font-semibold">
                    + Tambah Batch Ayam Baru
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-700 p-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-slate-800 p-4 sm:p-6 rounded-xl border border-slate-700 overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[860px] text-sm">

                        <thead class="border-b border-slate-700 text-slate-400">
                            <tr>
                                <th class="text-left py-3 px-3">ID Batch</th>
                                <th class="text-left px-3">Kandang</th>
                                <th class="text-left px-3">Jenis</th>
                                <th class="text-left px-3">Umur</th>
                                <th class="text-left px-3">Populasi</th>
                                <th class="text-left px-3">Status</th>
                                <th class="text-left px-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($batches as $batch)
                            <tr class="border-b border-slate-700 hover:bg-slate-700/40">

                                <td class="py-3 px-3 font-semibold text-white">
                                    {{ $batch->kode_batch }}
                                </td>

                                <td class="px-3 text-slate-300">
                                    {{ $batch->kandang }}
                                </td>

                                <td class="px-3 text-slate-300">
                                    {{ $batch->jenis_ayam }}
                                </td>

                                <td class="px-3 text-yellow-400 font-semibold">
                                    {{ $batch->umur_minggu }} Minggu
                                </td>

                                <td class="px-3 text-slate-300">
                                    {{ number_format($batch->populasi) }}
                                </td>

                                <td class="px-3">
                                    @if($batch->status_produksi == 'Produktif')
                                        <span class="bg-green-600 px-2 py-1 rounded text-xs whitespace-nowrap">
                                            Produktif
                                        </span>
                                    @elseif($batch->status_produksi == 'Mendekati Afkir')
                                        <span class="bg-yellow-500 text-black px-2 py-1 rounded text-xs whitespace-nowrap">
                                            Mendekati Afkir
                                        </span>
                                    @else
                                        <span class="bg-red-600 px-2 py-1 rounded text-xs whitespace-nowrap">
                                            Afkir
                                        </span>
                                    @endif
                                </td>

                                <td class="px-3">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('manajemen.kandang.edit', $batch->id) }}"
                                           class="text-yellow-300 hover:text-yellow-200 text-sm font-semibold">
                                            Edit
                                        </a>

                                        <form action="{{ route('manajemen.kandang.destroy', $batch->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Yakin hapus data?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-300 hover:text-red-200 text-sm font-semibold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
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

            </div>

        </div>
    </main>
</div>

<script>
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebar-overlay');
const openSidebar = document.getElementById('open-sidebar');
const closeSidebar = document.getElementById('close-sidebar');

function showSidebar() {
    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
}

function hideSidebar() {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
}

openSidebar?.addEventListener('click', showSidebar);
closeSidebar?.addEventListener('click', hideSidebar);
overlay?.addEventListener('click', hideSidebar);
</script>

</body>
</html>