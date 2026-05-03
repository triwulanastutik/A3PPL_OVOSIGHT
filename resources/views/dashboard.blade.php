=<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 h-screen bg-slate-800 text-white flex flex-col justify-between">
        <div>
            <div class="p-6 text-xl font-bold">OvoSight</div>

            <nav class="space-y-2 px-3">
                <a href="/dashboard" class="block px-3 py-2 bg-green-700 border-l-4 border-green-400">
                    Dashboard
                </a>
            </nav>
        </div>

        <div class="p-3">
            <form method="POST" action="/logout">
                @csrf
                <button class="w-full text-left px-3 py-2 hover:bg-red-600 rounded">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-6">

        <h1 class="text-2xl font-bold mb-4">Dashboard OvoSight</h1>

        <!-- FILTER -->
        <div class="flex gap-2 mb-6">
            <a href="?range=7d"
               class="{{ $range=='7d' ? 'bg-green-600 text-white' : 'bg-gray-200' }} px-3 py-1 rounded">
                7 Hari
            </a>

            <a href="?range=30d"
               class="{{ $range=='30d' ? 'bg-green-600 text-white' : 'bg-gray-200' }} px-3 py-1 rounded">
                30 Hari
            </a>

            <a href="?range=1y"
               class="{{ $range=='1y' ? 'bg-green-600 text-white' : 'bg-gray-200' }} px-3 py-1 rounded">
                1 Tahun
            </a>
        </div>

        <!-- SUMMARY -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <p>Total</p>
                <h2 class="text-xl font-bold">{{ $totalTelur }}</h2>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p>Layak</p>
                <h2 class="text-xl text-green-600 font-bold">{{ $totalLayak }}</h2>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p>Tidak Layak</p>
                <h2 class="text-xl text-red-600 font-bold">{{ $totalTidakLayak }}</h2>
            </div>
        </div>

        <!-- PERSENTASE -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold">Layak: {{ $persenLayak }}%</h2>
        </div>

        <!-- CHART -->
        <div class="bg-white p-4 rounded shadow mb-6">
            <canvas id="chart"></canvas>
        </div>

        <!-- TABLE -->
        <div class="bg-white p-4 rounded shadow">
            <table class="w-full text-sm">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Sensor</th>
                        <th>Batch</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestLogs as $log)
                    <tr>
                        <td>{{ $log->waktu }}</td>
                        <td>{{ $log->sensor_id }}</td>
                        <td>{{ $log->batch }}</td>
                        <td>{{ $log->jumlah_telur }}</td>
                        <td>{{ $log->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>

</div>

<script>
const labels = @json(collect($chart)->pluck('label'));
const data = @json(collect($chart)->pluck('total'));

new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Produksi Telur',
            data: data,
        }]
    }
});
</script>

</body>
</html>