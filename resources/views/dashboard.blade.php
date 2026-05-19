<!DOCTYPE html>
<html>
<head>
    <title>OvoSight Dashboard</title>
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
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm bg-green-600 text-white font-medium transition-all">

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
            <div>
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <p class="text-slate-400">Ringkasan operasional IoT</p>
            </div>
        </div>

        <!-- REALTIME IoT MONITOR (paling atas) -->
        <div class="bg-slate-800 p-6 rounded-xl mb-8 border border-slate-700">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold">Monitor IoT Real-Time</h2>
                <div class="flex items-center gap-2">
                    <span id="status-dot" class="w-3 h-3 rounded-full bg-yellow-400 animate-pulse"></span>
                    <span id="status-text" class="text-xs text-slate-400">Menunggu data...</span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-900 p-4 rounded-lg border border-slate-600">
                    <p class="text-xs text-slate-400 mb-1">Sensor ID</p>
                    <p id="rt-sensor-id" class="text-white font-bold text-sm">—</p>
                    <p id="rt-waktu" class="text-xs text-slate-500 mt-1">—</p>
                </div>
                <div class="bg-slate-900 p-4 rounded-lg border border-slate-600">
                    <p class="text-xs text-slate-400 mb-1">Berat Telur</p>
                    <p id="rt-berat" class="text-yellow-400 font-bold text-2xl">—</p>
                    <p class="text-xs text-slate-400">gram</p>
                </div>
                <div class="bg-slate-900 p-4 rounded-lg border border-slate-600">
                    <p class="text-xs text-slate-400 mb-1">Cahaya Tembus (IR)</p>
                    <p id="rt-ir" class="text-blue-400 font-bold text-2xl">—</p>
                    <p id="rt-ir-label" class="text-xs text-slate-400">—</p>
                </div>
                <div class="bg-slate-900 p-4 rounded-lg border border-slate-600">
                    <p class="text-xs text-slate-400 mb-1">Status</p>
                    <p id="rt-status" class="font-bold text-sm px-2 py-1 rounded inline-block mt-1">—</p>
                    <p class="text-xs text-slate-500 mt-1">hasil deteksi</p>
                </div>
            </div>
        </div>

        <!-- SUMMARY -->
        <div class="grid grid-cols-4 gap-6 mb-8">

            <!-- TOTAL -->
            <div class="bg-slate-800 p-6 rounded-xl border border-green-500">
                <p class="text-sm text-slate-400">Total Hari Ini</p>

                <h2 class="text-3xl text-green-400 font-bold">
                    {{ number_format($todayTotal ?? 0) }}
                </h2>

                <p class="text-sm mt-2 font-semibold
                    {{ ($trendPercent ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    {{ ($trendPercent ?? 0) >= 0 ? '↑' : '↓' }}
                    {{ abs($trendPercent ?? 0) }}% vs kemarin
                </p>
            </div>

            <!-- LAYAK -->
            <div class="bg-slate-800 p-6 rounded-xl border border-yellow-500">
                <p class="text-sm text-slate-400">Layak Jual</p>

                <h2 class="text-3xl text-yellow-400 font-bold">
                    {{ number_format($totalLayak ?? 0) }}
                </h2>

                <p class="text-xs text-slate-400 mt-2">
                    dari total produksi
                </p>
            </div>

            <!-- TIDAK LAYAK -->
            <div class="bg-slate-800 p-6 rounded-xl border border-red-500">
                <p class="text-sm text-slate-400">Tidak Layak</p>

                <h2 class="text-3xl text-red-400 font-bold">
                    {{ number_format($totalTidakLayak ?? 0) }}
                </h2>

                <p class="text-xs text-slate-400 mt-2">
                    perlu sortir ulang
                </p>
            </div>

            <!-- EFISIENSI -->
            <div class="bg-slate-800 p-6 rounded-xl border border-blue-500">
                <p class="text-sm text-slate-400">Efisiensi</p>

                <h2 class="text-3xl text-blue-400 font-bold">
                    {{ $persenLayak ?? 0 }}%
                </h2>

                <p class="text-xs mt-2 text-green-400">
                    Sensor normal
                </p>
            </div>

        </div>

        <!-- CHART + DONUT -->
        <div class="grid grid-cols-3 gap-6 mb-8">

            <!-- BAR -->
            <div class="col-span-2 bg-slate-800 p-6 rounded-xl">
                <div class="flex justify-between mb-4">
                    <h2 class="font-bold">Tren Produksi</h2>
                </div>

                <canvas id="chart"></canvas>
            </div>

            <!-- DONUT -->
            <div class="bg-slate-800 p-6 rounded-xl flex flex-col items-center">
                <h2 class="font-bold mb-4">Klasifikasi</h2>

                <canvas id="donutChart" class="w-40"></canvas>

                <div class="mt-4 text-sm space-y-1 text-center">
                    <p class="text-green-400">Layak: {{ $totalLayak ?? 0 }}</p>
                    <p class="text-red-400">Tidak: {{ $totalTidakLayak ?? 0 }}</p>
                </div>
            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-slate-800 p-6 rounded-xl">
            <h2 class="font-bold mb-4">Log Sensor Terbaru</h2>

            <table class="w-full text-sm">
                <thead class="text-slate-400 border-b border-slate-700">
                    <tr>
                        <th class="py-2 text-left pl-2">Waktu</th>
                        <th class="py-2 text-left">Sensor</th>
                        <th class="py-2 text-left">Batch</th>
                        <th class="py-2 text-left">Berat (g)</th>
                        {{-- <th class="py-2 text-left">IR</th> --}}
                        <th class="py-2 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($latestLogs as $log)
                    <tr class="border-b border-slate-700">
                        <td class="py-2">{{ $log->waktu ?? $log->created_at }}</td>
                        <td>{{ $log->sensor_id }}</td>
                        <td>{{ $log->batch }}</td>
                        <td>{{ $log->units }}</td>
                        <td>
                            <span class="px-2 py-1 text-xs rounded font-semibold
                                {{ $log->status == 'PRODUKTIF' ? 'bg-green-600' : '' }}
                                {{ $log->status == 'PERINGATAN' ? 'bg-yellow-500' : '' }}
                                {{ $log->status == 'WASPADA' ? 'bg-red-600' : '' }}">
                                {{ $log->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-slate-400">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </main>
</div>

<!-- SCRIPT CHART -->
<script>
const labels = @json($chart->pluck('label') ?? []);
const layak  = @json($chart->pluck('layak') ?? []);
const tidak  = @json($chart->pluck('tidak') ?? []);

new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            { label: 'Layak',       data: layak, backgroundColor: '#22c55e' },
            { label: 'Tidak Layak', data: tidak, backgroundColor: '#ef4444' }
        ]
    },
    options: {
        plugins: {
            legend: { labels: { color: 'white' } }
        },
        scales: {
            x: { stacked: true, ticks: { color: 'white' } },
            y: { stacked: true, ticks: { color: 'white' } }
        }
    }
});

new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: ['Layak', 'Tidak Layak'],
        datasets: [{
            data: [{{ $totalLayak ?? 0 }}, {{ $totalTidakLayak ?? 0 }}],
            backgroundColor: ['#22c55e', '#ef4444']
        }]
    },
    options: {
        plugins: {
            legend: { labels: { color: 'white' } }
        }
    }
});
</script>

<!-- SCRIPT POLLING IoT (terpisah dari script chart) -->
<script>
let lastLogId = null;

function setStatusColor(status) {
    const el = document.getElementById('rt-status');
    el.textContent = status || '—';
    el.className = 'font-bold text-sm px-2 py-1 rounded inline-block mt-1';
    if (status === 'PRODUKTIF')       el.className += ' bg-green-600 text-white';
    else if (status === 'PERINGATAN') el.className += ' bg-yellow-500 text-black';
    else if (status === 'WASPADA')    el.className += ' bg-red-600 text-white';
}

async function fetchLatest() {
    try {
        const res  = await fetch('/api/latest');
        const data = await res.json();

        const dot  = document.getElementById('status-dot');
        const text = document.getElementById('status-text');
        dot.className    = 'w-3 h-3 rounded-full bg-green-500 animate-pulse';
        text.textContent = 'Update: ' + new Date().toLocaleTimeString('id-ID');

        if (data.lastLog && data.lastLog.id !== lastLogId) {
            lastLogId = data.lastLog.id;
            const log = data.lastLog;

            document.getElementById('rt-sensor-id').textContent = log.sensor_id ?? '—';
            document.getElementById('rt-berat').textContent     = log.berat ?? '—';
            document.getElementById('rt-ir').textContent        = log.ir ?? '—';
            document.getElementById('rt-waktu').textContent     = log.waktu ?? log.created_at ?? '—';

            const irLabel = document.getElementById('rt-ir-label');
            if (log.ir !== null && log.ir !== undefined) {
                irLabel.textContent = parseInt(log.ir) > 500 ? 'Terlalu transparan' : 'Normal';
                irLabel.className   = parseInt(log.ir) > 500 ? 'text-xs text-red-400' : 'text-xs text-green-400';
            }

            setStatusColor(log.status);

            ['rt-berat', 'rt-ir', 'rt-status'].forEach(function(id) {
                var el = document.getElementById(id);
                el.style.transition = 'opacity 0.3s';
                el.style.opacity    = '0.2';
                setTimeout(function() { el.style.opacity = '1'; }, 300);
            });
        }
    } catch (e) {
        const dot  = document.getElementById('status-dot');
        const text = document.getElementById('status-text');
        dot.className    = 'w-3 h-3 rounded-full bg-red-500';
        text.textContent = 'Gagal terhubung';
    }
}

fetchLatest();
setInterval(fetchLatest, 5000);
</script>

</body>
</html>
