<!DOCTYPE html>
<html>
<head>
    <title>Produksi Telur</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-slate-900 text-white">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-950 p-5">
        <h1 class="text-xl font-bold mb-6">OvoSight</h1>

        <nav class="space-y-2">
            <a href="{{ route('dashboard') }}" class="block hover:bg-slate-800 px-3 py-2 rounded">Dashboard</a>
            <a href="{{ route('produksi') }}" class="block bg-green-600 px-3 py-2 rounded">Produksi</a>
            <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-slate-700 mt-4">
                @csrf
                <button type="submit"
                    class="w-full text-left px-3 py-2 rounded hover:bg-red-700 text-red-400 hover:text-white transition text-sm">
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-8">

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
