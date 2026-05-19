<!DOCTYPE html>
<html>
<head>
    <title>Produksi Telur</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-slate-900 text-white">

<div class="flex min-h-screen">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-60 bg-slate-950 text-white flex flex-col shrink-0">

        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-slate-800">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center text-sm font-bold">
                    O
                </div>

                <span class="font-bold text-lg tracking-tight">
                    OvoSight
                </span>
            </div>
        </div>

        {{-- Farm --}}
        <div class="px-5 py-3 border-b border-slate-800">
            <p class="text-xs text-slate-400 uppercase tracking-widest">
                Farm
            </p>

            <p class="font-semibold text-sm mt-0.5">
                Lubada Farm
            </p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">

            {{-- DASHBOARD ACTIVE --}}
            <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">

                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>

                Dashboard
            </a>

            <a href="{{ route('produksi') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm bg-green-600 text-white font-medium transition-all">

                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>

                Produksi
            </a>

            <a href="{{ route('manajemen.kandang') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">

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

        {{-- Bottom --}}
        <div class="px-3 py-4 border-t border-slate-800">
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

    <!-- MAIN -->
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

        <div class="p-5">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Produksi Telur</h1>

            <a href="{{ route('produksi.export', ['start'=>$start,'end'=>$end]) }}"
               class="bg-green-600 px-4 py-2 rounded">
                Export PDF
            </a>
        </div>

        <!-- FILTER TANGGAL -->
        <form method="GET" action="{{ route('produksi') }}"
              class="bg-slate-800 p-4 rounded-xl flex items-end gap-4 mb-6">

            <div>
                <label class="text-xs text-slate-400">Dari</label>
                <input type="date" name="start"
                       value="{{ $start }}"
                       class="bg-slate-900 px-3 py-2 rounded text-white">
            </div>

            <div>
                <label class="text-xs text-slate-400">Hingga</label>
                <input type="date" name="end"
                       value="{{ $end }}"
                       class="bg-slate-900 px-3 py-2 rounded text-white">
            </div>

            <button class="bg-green-600 px-4 py-2 rounded">
                Terapkan
            </button>

        </form>

        <!-- SUMMARY -->
        <div class="grid grid-cols-4 gap-4 mb-6">

            <div class="bg-slate-800 p-4 rounded">
                <p class="text-sm text-slate-400">Total Produksi</p>
                <h2 class="text-xl font-bold text-green-400">{{ number_format($total) }}</h2>
            </div>

            <div class="bg-slate-800 p-4 rounded">
                <p class="text-sm text-slate-400">Layak</p>
                <h2 class="text-xl text-green-400 font-bold">{{ number_format($layak) }}</h2>
            </div>

            <div class="bg-slate-800 p-4 rounded">
                <p class="text-sm text-slate-400">Tidak Layak</p>
                <h2 class="text-xl text-red-400 font-bold">{{ number_format($tidak) }}</h2>
            </div>

            <div class="bg-slate-800 p-4 rounded">
                <p class="text-sm text-slate-400">Rata / Hari</p>
                <h2 class="text-xl text-blue-400 font-bold">{{ number_format($rata) }}</h2>
            </div>

        </div>

        <!-- CHART -->
        <div class="bg-slate-800 p-6 rounded mb-6">
            <canvas id="chart"></canvas>
        </div>

        <!-- TABLE -->
        <div class="bg-slate-800 p-6 rounded">
            <table class="w-full text-sm">
                <thead class="text-slate-400 border-b border-slate-700">
                    <tr>
                        <th class="py-2 text-left">Waktu</th>
                        <th>Sensor</th>
                        <th>Batch</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $row)
                    <tr class="border-b border-slate-700">
                        <td class="py-2">{{ $row->created_at }}</td>
                        <td>{{ $row->sensor_id }}</td>
                        <td>{{ $row->batch }}</td>
                        <td>{{ $row->units }}</td>
                        <td>
                            <span class="px-2 py-1 text-xs rounded
                                {{ $row->status == 'PRODUKTIF' ? 'bg-green-600' : '' }}
                                {{ $row->status == 'PERINGATAN' ? 'bg-yellow-500' : '' }}
                                {{ $row->status == 'WASPADA' ? 'bg-red-600' : '' }}">
                                {{ $row->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $data->appends(['start'=>$start,'end'=>$end])->links() }}
            </div>

        </div>
    </div>
    </main>
</div>

<script>
const labels = @json($chart->pluck('label'));
const data = @json($chart->pluck('total'));

new Chart(document.getElementById('chart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Produksi',
            data: data,
            borderColor: '#22c55e',
            tension: 0.4
        }]
    },
    options: {
        plugins: {
            legend: { labels: { color: 'white' } }
        },
        scales: {
            x: { ticks: { color: 'white' }},
            y: { ticks: { color: 'white' }}
        }
    }
});
</script>

</body>
</html>
