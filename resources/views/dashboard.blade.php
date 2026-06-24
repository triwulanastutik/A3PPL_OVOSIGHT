<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OvoSight Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white overflow-x-hidden">

@php
    $statusRaw = strtolower($latestLog->status ?? '-');

    $statusText = $statusRaw === 'layak'
        ? 'Layak'
        : ($statusRaw === 'tidak' ? 'Tidak' : '-');

    $statusClass = $statusRaw === 'layak'
        ? 'bg-green-600 text-white'
        : ($statusRaw === 'tidak' ? 'bg-red-600 text-white' : 'bg-slate-600 text-white');
@endphp

<div id="sidebar-backdrop"
     class="fixed inset-0 bg-black/60 z-40 hidden md:hidden">
</div>

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
           class="fixed md:static inset-y-0 left-0 z-50 w-60 bg-slate-950 text-white flex flex-col shrink-0 transform -translate-x-full md:translate-x-0 transition-transform duration-200">

        <div class="px-5 py-5 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center text-sm font-bold">
                    O
                </div>
                <span class="font-bold text-lg tracking-tight">OvoSight</span>
            </div>

            <button id="close-sidebar"
                    type="button"
                    class="md:hidden text-slate-400 hover:text-white text-2xl leading-none">
                ×
            </button>
        </div>

        <div class="px-5 py-3 border-b border-slate-800">
            <p class="text-xs text-slate-400 uppercase tracking-widest">Farm</p>
            <p class="font-semibold text-sm mt-0.5">Lubada Farm</p>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-0.5">
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-2.5 rounded-lg text-sm bg-green-600 text-white font-medium">
                Dashboard
            </a>

            <a href="{{ route('produksi') }}"
               class="flex items-center px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800">
                Produksi
            </a>

            <a href="{{ route('data.ayam') }}"
               class="flex items-center px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800">
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
    <main class="flex-1 flex flex-col w-full min-w-0">

        {{-- TOPBAR --}}
        <header class="bg-slate-950 border-b border-slate-800 px-4 md:px-6 py-3 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <button id="open-sidebar"
                        type="button"
                        class="md:hidden bg-slate-800 hover:bg-slate-700 text-white px-3 py-2 rounded-lg text-sm">
                    ☰
                </button>

                <span class="font-semibold text-white truncate">Lubada Farm</span>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <div class="text-right hidden sm:block">
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

        <div class="p-4 md:p-5">

            {{-- HEADER --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <p class="text-slate-400 text-sm mt-1">
                    Monitoring kualitas telur dan hasil klasifikasi sensor.
                </p>
            </div>

            {{-- REAL-TIME MONITOR --}}
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-4 md:p-5 mb-6">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
                    <div>
                        <h2 class="font-bold text-lg">Monitor Telur Real-Time</h2>
                        <p class="text-xs text-slate-400 mt-1">
                            Data terbaru dari sensor telur berdasarkan kandang/batch.
                        </p>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <span id="realtime-indicator"
                              class="w-3 h-3 rounded-full bg-yellow-500 inline-block"></span>
                        <span id="realtime-text">Menunggu data...</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">

                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4 min-w-0">
                        <p class="text-xs text-slate-400">ID Kandang / Batch</p>
                        <h3 id="id-kandang" class="text-lg font-bold mt-2 break-words">
                            {{ $latestLog->id_kandang ?? '-' }}
                        </h3>
                    </div>

                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4 min-w-0">
                        <p class="text-xs text-slate-400">Tanggal & Waktu</p>
                        <h3 id="tanggal" class="text-base font-bold mt-2 break-words">
                            {{ $latestLog?->tanggal ? \Carbon\Carbon::parse($latestLog->tanggal)->format('d M Y') : '-' }}
                        </h3>
                        <p id="waktu" class="text-xs text-slate-400 mt-1">
                            {{ $latestLog->waktu ?? '-' }}
                        </p>
                    </div>

                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4 min-w-0">
                        <p class="text-xs text-slate-400">Berat</p>
                        <h3 id="berat" class="text-2xl font-bold text-yellow-400 mt-2">
                            {{ $latestLog->berat ?? '-' }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">gram</p>
                    </div>

                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4 min-w-0">
                        <p class="text-xs text-slate-400">Cahaya</p>
                        <h3 id="cahaya" class="text-2xl font-bold text-blue-400 mt-2">
                            {{ $latestLog->cahaya ?? '-' }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">nilai sensor</p>
                    </div>

                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4 min-w-0">
                        <p class="text-xs text-slate-400">Status</p>
                        <span id="status"
                              class="inline-flex mt-2 px-3 py-1.5 rounded-lg text-sm font-bold {{ $statusClass }}">
                            {{ $statusText }}
                        </span>
                        <p class="text-xs text-slate-400 mt-2">hasil deteksi</p>
                    </div>

                </div>
            </div>

            {{-- GRAFIK MINGGUAN --}}
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-4 md:p-5">

                <div class="mb-5">
                    <h2 class="font-bold text-lg">Grafik Klasifikasi Telur Mingguan</h2>
                </div>

                <div class="bg-slate-900 border border-slate-700 rounded-xl p-4 h-72 md:h-96">
                    <canvas id="weeklyChart"></canvas>
                </div>

            </div>

        </div>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    const openSidebar = document.getElementById('open-sidebar');
    const closeSidebar = document.getElementById('close-sidebar');

    function showSidebar() {
        sidebar.classList.remove('-translate-x-full');
        backdrop.classList.remove('hidden');
    }

    function hideSidebar() {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    }

    openSidebar?.addEventListener('click', showSidebar);
    closeSidebar?.addEventListener('click', hideSidebar);
    backdrop?.addEventListener('click', hideSidebar);
</script>

<script>
    const chartLabels = @json($chartLabels);
    const chartLayak = @json($chartLayak);
    const chartTidak = @json($chartTidak);

    const maxValue = Math.max(...chartLayak, ...chartTidak, 50);

    let stepSize;
    let suggestedMax;

    if (maxValue <= 100) {
        stepSize = 10;
        suggestedMax = 100;
    } else if (maxValue <= 150) {
        stepSize = 10;
        suggestedMax = 150;
    } else if (maxValue <= 200) {
        stepSize = 20;
        suggestedMax = 200;
    } else {
        stepSize = 20;
        suggestedMax = Math.ceil((maxValue + 20) / 20) * 20;
    }

    const valueLabelPlugin = {
        id: 'valueLabelPlugin',
        afterDatasetsDraw(chart) {
            const { ctx } = chart;

            chart.data.datasets.forEach((dataset, datasetIndex) => {
                const meta = chart.getDatasetMeta(datasetIndex);

                meta.data.forEach((bar, index) => {
                    const value = dataset.data[index];

                    if (!value || value === 0) return;

                    ctx.save();
                    ctx.font = 'bold 11px sans-serif';
                    ctx.fillStyle = '#f1f5f9';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    ctx.fillText(value, bar.x, bar.y - 4);
                    ctx.restore();
                });
            });
        }
    };

    new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    label: 'Layak',
                    data: chartLayak,
                    backgroundColor: 'rgba(34, 197, 94, 0.85)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                },
                {
                    label: 'Tidak Layak',
                    data: chartTidak,
                    backgroundColor: 'rgba(239, 68, 68, 0.85)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 28
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#cbd5e1',
                        boxWidth: 14,
                        boxHeight: 14
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
                    grid: {
                        color: 'rgba(148, 163, 184, 0.15)'
                    },
                    ticks: {
                        color: '#cbd5e1'
                    }
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: suggestedMax,
                    ticks: {
                        color: '#cbd5e1',
                        stepSize: stepSize,
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Telur',
                        color: '#cbd5e1'
                    },
                    grid: {
                        color: 'rgba(148, 163, 184, 0.15)'
                    }
                }
            }
        },
        plugins: [valueLabelPlugin]
    });

    function formatTanggal(value) {
        if (!value) return '-';

        const bulan = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        const dateOnly = String(value).split('T')[0];
        const parts = dateOnly.split('-');

        if (parts.length === 3) {
            return `${parts[2]} ${bulan[parseInt(parts[1]) - 1]} ${parts[0]}`;
        }

        return value;
    }

    function normalizeStatus(value) {
        const status = String(value || '').toLowerCase();

        if (status === 'layak') {
            return {
                text: 'Layak',
                className: 'inline-flex mt-2 px-3 py-1.5 rounded-lg text-sm font-bold bg-green-600 text-white'
            };
        }

        if (status === 'tidak' || status === 'tidak layak') {
            return {
                text: 'Tidak',
                className: 'inline-flex mt-2 px-3 py-1.5 rounded-lg text-sm font-bold bg-red-600 text-white'
            };
        }

        return {
            text: '-',
            className: 'inline-flex mt-2 px-3 py-1.5 rounded-lg text-sm font-bold bg-slate-600 text-white'
        };
    }

    let lastLogId = {{ $latestLog->id ?? 'null' }};

    async function fetchLatestSensor() {
        try {
            const response = await fetch('/api/sensor/latest', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('HTTP ' + response.status);

            const payload = await response.json();

            if (!payload.success) {
                document.getElementById('realtime-indicator').className =
                    'w-3 h-3 rounded-full bg-yellow-500 inline-block';
                document.getElementById('realtime-text').textContent = 'Menunggu data...';
                return;
            }

            const data = payload.data;

            document.getElementById('id-kandang').textContent =
                data.id_kandang ?? '-';

            document.getElementById('tanggal').textContent =
                formatTanggal(data.tanggal ?? null);

            document.getElementById('waktu').textContent =
                data.waktu ?? '-';

            document.getElementById('berat').textContent =
                data.berat ?? '-';

            document.getElementById('cahaya').textContent =
                data.ir ?? data.cahaya ?? '-';

            const status = normalizeStatus(data.status);
            const statusEl = document.getElementById('status');
            statusEl.textContent = status.text;
            statusEl.className = status.className;

            if (lastLogId !== data.id) {
                lastLogId = data.id;

                document.getElementById('realtime-indicator').className =
                    'w-3 h-3 rounded-full bg-green-500 inline-block animate-pulse';
                document.getElementById('realtime-text').textContent = 'Data baru masuk!';

                setTimeout(() => {
                    document.getElementById('realtime-indicator').className =
                        'w-3 h-3 rounded-full bg-green-500 inline-block';
                    document.getElementById('realtime-text').textContent = 'Data real-time aktif';
                }, 2000);
            } else {
                document.getElementById('realtime-indicator').className =
                    'w-3 h-3 rounded-full bg-green-500 inline-block';
                document.getElementById('realtime-text').textContent = 'Data real-time aktif';
            }

        } catch (error) {
            console.error('Polling error:', error);

            document.getElementById('realtime-indicator').className =
                'w-3 h-3 rounded-full bg-red-500 inline-block';
            document.getElementById('realtime-text').textContent = 'Gagal mengambil data';
        }
    }

    fetchLatestSensor();
    setInterval(fetchLatestSensor, 3000);
</script>

</body>
</html>