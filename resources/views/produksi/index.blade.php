<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produksi Telur - OvoSight</title>

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

                <span class="font-bold text-lg tracking-tight">
                    OvoSight
                </span>
            </div>

            <button type="button"
                    id="close-sidebar"
                    class="lg:hidden text-slate-400 hover:text-white text-2xl leading-none">
                &times;
            </button>
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

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                Dashboard
            </a>

            <a href="{{ route('produksi') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm bg-green-600 text-white font-medium transition-all">
                Produksi
            </a>

            <a href="{{ route('data.ayam') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                Data Ayam
            </a>

            <a href="{{ route('jadwal.vaksinasi') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                Jadwal Vaksinasi
            </a>

        </nav>

        {{-- Logout --}}
        <div class="px-3 py-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-red-400 hover:bg-slate-800 transition-all">
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
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

            <div class="flex items-center gap-2 shrink-0">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-white leading-none">
                        {{ auth()->user()->name ?? 'Admin OvoSight' }}
                    </p>

                    <p class="text-xs text-slate-400">
                        OWNER
                    </p>
                </div>

                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>

        </header>

        <div class="p-4 sm:p-5 min-w-0">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div class="min-w-0">
                    <h1 class="text-2xl font-bold">
                        Produksi Telur
                    </h1>

                    <p class="text-slate-400 text-sm sm:text-base mt-1">
                        Rekap produksi telur, klasifikasi, dan record hasil sensor
                    </p>
                </div>

                @php
                    $exportUrl = \Illuminate\Support\Facades\Route::has('produksi.export')
                        ? route('produksi.export', ['start' => $start, 'end' => $end])
                        : url('/produksi/export') . '?' . http_build_query(['start' => $start, 'end' => $end]);
                @endphp

                <a href="{{ $exportUrl }}"
                   class="w-full md:w-auto text-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    Export PDF
                </a>
            </div>

            {{-- FILTER TANGGAL --}}
            <div class="bg-slate-800 p-4 sm:p-5 rounded-xl border border-slate-700 mb-6 sm:mb-8">
                <form method="GET" action="{{ route('produksi') }}"
                      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">

                    <div>
                        <label class="block text-xs text-slate-400 mb-1">
                            Tanggal Mulai
                        </label>

                        <input type="date"
                               name="start"
                               value="{{ $start }}"
                               class="w-full bg-white text-slate-900 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 mb-1">
                            Tanggal Akhir
                        </label>

                        <input type="date"
                               name="end"
                               value="{{ $end }}"
                               class="w-full bg-white text-slate-900 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Filter
                    </button>

                    <a href="{{ route('produksi') }}"
                       class="w-full bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-semibold text-center transition">
                        Reset
                    </a>

                </form>
            </div>

            {{-- SUMMARY PRODUKSI --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">

                <div class="bg-slate-800 p-5 sm:p-6 rounded-xl border border-green-500">
                    <p class="text-sm text-slate-400">
                        Total Produksi
                    </p>

                    <h2 class="text-3xl text-green-400 font-bold mt-2">
                        {{ number_format($total ?? 0) }}
                    </h2>

                    <p class="text-xs text-slate-500 mt-2">
                        Total telur terdeteksi
                    </p>
                </div>

                <div class="bg-slate-800 p-5 sm:p-6 rounded-xl border border-blue-500">
                    <p class="text-sm text-slate-400">
                        Telur Layak
                    </p>

                    <h2 class="text-3xl text-blue-400 font-bold mt-2">
                        {{ number_format($layak ?? 0) }}
                    </h2>

                    <p class="text-xs text-slate-500 mt-2">
                        {{ $persentaseLayak ?? 0 }}% dari total produksi
                    </p>
                </div>

                <div class="bg-slate-800 p-5 sm:p-6 rounded-xl border border-red-500">
                    <p class="text-sm text-slate-400">
                        Telur Tidak Layak
                    </p>

                    <h2 class="text-3xl text-red-400 font-bold mt-2">
                        {{ number_format($tidak ?? 0) }}
                    </h2>

                    <p class="text-xs text-slate-500 mt-2">
                        {{ $persentaseTidak ?? 0 }}% dari total produksi
                    </p>
                </div>

                <div class="bg-slate-800 p-5 sm:p-6 rounded-xl border border-yellow-500">
                    <p class="text-sm text-slate-400">
                        Rata-rata Produksi
                    </p>

                    <h2 class="text-3xl text-yellow-400 font-bold mt-2">
                        {{ number_format($rata ?? 0) }}
                    </h2>

                    <p class="text-xs text-slate-500 mt-2">
                        Telur per hari
                    </p>
                </div>

            </div>

            {{-- GRAFIK PRODUKSI LINE CHART --}}
            <div class="bg-slate-800 p-4 sm:p-6 rounded-xl border border-slate-700 mb-6 sm:mb-8">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="font-bold">
                            Grafik Produksi Telur
                        </h2>
                    </div>
                </div>

                <div class="h-72 sm:h-96">
                    <canvas id="produksiChart"></canvas>
                </div>
            </div>

            {{-- TABEL RECORD PRODUKSI --}}
            <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden">

                <div class="px-4 sm:px-5 py-4 border-b border-slate-700">
                    <h2 class="font-bold">
                        Record Produksi Telur
                    </h2>

                    <p class="text-xs text-slate-400 mt-1">
                        Data detail hasil deteksi sensor telur berdasarkan kandang atau batch
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[760px] text-left text-sm">

                        <thead class="bg-slate-900 text-slate-400 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">ID Kandang / Batch</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Waktu</th>
                                <th class="px-4 py-3">Berat</th>
                                <th class="px-4 py-3">Cahaya</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $log)
                                <tr class="border-t border-slate-700 hover:bg-slate-700/40 transition">

                                    <td class="px-4 py-3 font-semibold text-white">
                                        {{ $log->id_kandang ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-300">
                                        {{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}
                                    </td>

                                    <td class="px-4 py-3 text-slate-300">
                                        {{ $log->waktu }}
                                    </td>

                                    <td class="px-4 py-3 text-yellow-400 font-semibold">
                                        {{ $log->berat }} gram
                                    </td>

                                    <td class="px-4 py-3 text-blue-400 font-semibold">
                                        {{ $log->cahaya }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($log->status === 'layak')
                                            <span class="px-3 py-1 rounded-full bg-green-600 text-white text-xs font-semibold whitespace-nowrap">
                                                Layak
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-red-600 text-white text-xs font-semibold whitespace-nowrap">
                                                Tidak Layak
                                            </span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                        Belum ada data produksi telur.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <div class="px-4 sm:px-5 py-4 border-t border-slate-700 overflow-x-auto">
                    {{ $data->links() }}
                </div>

            </div>

        </div>
    </main>
</div>

{{-- SCRIPT LINE CHART PRODUKSI --}}
<script>
const chartData = @json($chart ?? []);

const labels = chartData.map(item => item.label);
const totalData = chartData.map(item => item.total);
const layakData = chartData.map(item => item.layak);
const tidakData = chartData.map(item => item.tidak);

new Chart(document.getElementById('produksiChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Total Telur',
                data: totalData,
                borderColor: '#22c55e',
                backgroundColor: '#22c55e',
                tension: 0.35,
                fill: false,
                pointRadius: 4,
                pointHoverRadius: 6
            },
            {
                label: 'Layak',
                data: layakData,
                borderColor: '#3b82f6',
                backgroundColor: '#3b82f6',
                tension: 0.35,
                fill: false,
                pointRadius: 4,
                pointHoverRadius: 6
            },
            {
                label: 'Tidak Layak',
                data: tidakData,
                borderColor: '#ef4444',
                backgroundColor: '#ef4444',
                tension: 0.35,
                fill: false,
                pointRadius: 4,
                pointHoverRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: 'white',
                    usePointStyle: true,
                    padding: 20
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.raw + ' telur';
                    }
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: 'rgba(148, 163, 184, 0.15)'
                },
                title: {
                    display: true,
                    text: 'Tanggal Produksi',
                    color: 'white'
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white',
                    precision: 0
                },
                grid: {
                    color: 'rgba(148, 163, 184, 0.15)'
                },
                title: {
                    display: true,
                    text: 'Jumlah Telur',
                    color: 'white'
                }
            }
        }
    }
});

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