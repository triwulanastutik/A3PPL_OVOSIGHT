<!DOCTYPE html>
<html>
<head>
    <title>OvoSight Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-slate-900 text-white">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-950 border-r border-slate-800 p-5">
        <h1 class="text-xl font-bold mb-6">OvoSight</h1>

        <nav class="space-y-2">
            <a class="block bg-green-600 px-3 py-2 rounded">Dashboard</a>
            <a href="{{ route('produksi') }}"
                class="block px-3 py-2 rounded hover:bg-slate-800">
                Produksi
            </a>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-8">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <p class="text-slate-400">Ringkasan operasional IoT</p>
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
                        <th class="py-2 text-left">Waktu</th>
                        <th>Sensor</th>
                        <th>Batch</th>
                        <th>Jumlah</th>
                        <th>Status</th>
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

    </main>
</div>

<!-- SCRIPT -->
<script>
const labels = @json($chart->pluck('label') ?? []);
const layak = @json($chart->pluck('layak') ?? []);
const tidak = @json($chart->pluck('tidak') ?? []);

new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            { label: 'Layak', data: layak, backgroundColor: '#22c55e' },
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

</body>
</html>