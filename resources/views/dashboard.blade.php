<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OvoSight Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white">

@php
    $statusRaw = strtolower($latestLog->status ?? '-');

    $statusText = $statusRaw === 'layak'
        ? 'Layak'
        : ($statusRaw === 'tidak' ? 'Tidak' : '-');

    $statusClass = $statusRaw === 'layak'
        ? 'bg-green-600 text-white'
        : ($statusRaw === 'tidak' ? 'bg-red-600 text-white' : 'bg-slate-600 text-white');
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
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <p class="text-slate-400 text-sm mt-1">
                    Monitoring kualitas telur dan hasil klasifikasi sensor.
                </p>
            </div>

            {{-- REAL-TIME MONITOR --}}
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-5 mb-6">

                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="font-bold text-lg">Monitor Telur Real-Time</h2>
                        <p class="text-xs text-slate-400 mt-1">
                            Data terbaru dari sensor telur.
                        </p>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <span id="realtime-indicator"
                              class="w-3 h-3 rounded-full bg-yellow-500 inline-block"></span>
                        <span id="realtime-text">Menunggu data...</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4">
                        <p class="text-xs text-slate-400">ID Telur</p>
                        <h3 id="id-telur" class="text-lg font-bold mt-2">
                            {{ $latestLog->id_telur ?? $latestLog->sensor_id ?? '-' }}
                        </h3>
                    </div>

                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4">
                        <p class="text-xs text-slate-400">Tanggal & Waktu</p>
                        <h3 id="tanggal" class="text-base font-bold mt-2">
                            {{ $latestLog?->tanggal ? \Carbon\Carbon::parse($latestLog->tanggal)->format('d M Y') : '-' }}
                        </h3>
                        <p id="waktu" class="text-xs text-slate-400 mt-1">
                            {{ $latestLog->waktu ?? '-' }}
                        </p>
                    </div>

                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4">
                        <p class="text-xs text-slate-400">Berat</p>
                        <h3 id="berat" class="text-2xl font-bold text-yellow-400 mt-2">
                            {{ $latestLog->berat ?? '-' }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">gram</p>
                    </div>

                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4">
                        <p class="text-xs text-slate-400">Cahaya</p>
                        <h3 id="cahaya" class="text-2xl font-bold text-blue-400 mt-2">
                            {{ $latestLog->cahaya ?? $latestLog->ir ?? '-' }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">nilai sensor</p>
                    </div>

                    <div class="bg-slate-900 border border-slate-700 rounded-xl p-4">
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
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-5">

                <div class="mb-5">
                    <h2 class="font-bold text-lg">Grafik Klasifikasi Telur Mingguan</h2>
                    <p class="text-xs text-slate-400 mt-1">
                        Sumbu X = hari, sumbu Y = jumlah telur. Setiap hari menampilkan telur layak dan tidak layak.
                    </p>
                </div>

                <div class="bg-slate-900 border border-slate-700 rounded-xl p-4">
                    <canvas id="weeklyChart" height="120"></canvas>
                </div>

            </div>

        </div>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const chartLabels = @json($chartLabels);
    const chartLayak = @json($chartLayak);
    const chartTidak = @json($chartTidak);

    const maxValue = Math.max(...chartLayak, ...chartTidak, 10);
    const suggestedMax = Math.ceil((maxValue + 5) / 10) * 10;

    const valueLabelPlugin = {
        id: 'valueLabelPlugin',
        afterDatasetsDraw(chart) {
            const { ctx } = chart;

            chart.data.datasets.forEach((dataset, datasetIndex) => {
                const meta = chart.getDatasetMeta(datasetIndex);

                meta.data.forEach((bar, index) => {
                    const value = dataset.data[index];

                    if (value === null || value === undefined) return;

                    ctx.save();
                    ctx.font = 'bold 12px sans-serif';
                    ctx.fillStyle = '#e5e7eb';
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
            maintainAspectRatio: true,
            layout: {
                padding: {
                    top: 24
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
                        stepSize: 10,
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

    async function fetchLatestSensor() {
        try {
            const response = await fetch('/api/latest', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            const payload = await response.json();
            const data = payload.data ?? payload.latestLog ?? payload;

            document.getElementById('id-telur').textContent =
                data.id_telur ?? data.sensor_id ?? '-';

            document.getElementById('tanggal').textContent =
                formatTanggal(data.tanggal ?? data.created_at ?? null);

            document.getElementById('waktu').textContent =
                data.waktu ?? '-';

            document.getElementById('berat').textContent =
                data.berat ?? '-';

            document.getElementById('cahaya').textContent =
                data.cahaya ?? data.ir ?? '-';

            const status = normalizeStatus(data.status);
            const statusEl = document.getElementById('status');
            statusEl.textContent = status.text;
            statusEl.className = status.className;

            document.getElementById('realtime-indicator').className =
                'w-3 h-3 rounded-full bg-green-500 inline-block';

            document.getElementById('realtime-text').textContent =
                'Data real-time aktif';

        } catch (error) {
            document.getElementById('realtime-indicator').className =
                'w-3 h-3 rounded-full bg-red-500 inline-block';

            document.getElementById('realtime-text').textContent =
                'Gagal mengambil data';
        }
    }

    fetchLatestSensor();
    setInterval(fetchLatestSensor, 5000);
</script>

</body>
</html>
