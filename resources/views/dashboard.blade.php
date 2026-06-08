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
                <span class="font-bold text-lg tracking-tight">OvoSight</span>
            </div>
        </div>

        {{-- Farm --}}
        <div class="px-5 py-3 border-b border-slate-800">
            <p class="text-xs text-slate-400 uppercase tracking-widest">Farm</p>
            <p class="font-semibold text-sm mt-0.5">Lubada Farm</p>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm bg-green-600 text-white font-medium transition-all">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('produksi') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                Produksi
            </a>

            <a href="{{ route('data.ayam') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                Data Ayam
            </a>

            <a href="{{ route('jadwal.vaksinasi') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
                Jadwal Vaksinasi
            </a>

        </nav>

        {{-- Logout --}}
        <div class="px-3 py-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-red-400 hover:bg-slate-800 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1 flex flex-col">

        {{-- TOPBAR --}}
        <header class="bg-slate-950 border-b border-slate-800 px-6 py-3 flex items-center justify-between shrink-0">
            <div>
                <span class="font-semibold text-white">Lubada Farm</span>
            </div>

            {{-- User info --}}
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
                <p class="text-slate-400">Monitoring kualitas telur dan hasil klasifikasi hari ini</p>
            </div>

            {{-- MONITOR TELUR REAL-TIME --}}
            <div class="bg-slate-800 p-6 rounded-xl mb-8 border border-slate-700">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold">Monitor Telur Real-Time</h2>
                    <div class="flex items-center gap-2">
                        <span id="status-dot" class="w-3 h-3 rounded-full bg-yellow-400 animate-pulse"></span>
                        <span id="status-text" class="text-xs text-slate-400">Menunggu data...</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="bg-slate-900 p-4 rounded-lg border border-slate-600">
                        <p class="text-xs text-slate-400 mb-1">ID Telur</p>
                        <p id="rt-id-telur" class="text-white font-bold text-sm">{{ $latestLog->id_telur ?? '—' }}</p>
                    </div>

                    <div class="bg-slate-900 p-4 rounded-lg border border-slate-600">
                        <p class="text-xs text-slate-400 mb-1">Tanggal & Waktu</p>
                        <p id="rt-tanggal" class="text-white font-semibold text-sm">{{ $latestLog ? \Carbon\Carbon::parse($latestLog->tanggal)->format('d M Y') : '—' }}</p>
                        <p id="rt-waktu" class="text-xs text-slate-500 mt-1">{{ $latestLog->waktu ?? '—' }}</p>
                    </div>

                    <div class="bg-slate-900 p-4 rounded-lg border border-slate-600">
                        <p class="text-xs text-slate-400 mb-1">Berat</p>
                        <p id="rt-berat" class="text-yellow-400 font-bold text-2xl">{{ $latestLog->berat ?? '—' }}</p>
                        <p class="text-xs text-slate-400">gram</p>
                    </div>

                    <div class="bg-slate-900 p-4 rounded-lg border border-slate-600">
                        <p class="text-xs text-slate-400 mb-1">Cahaya</p>
                        <p id="rt-cahaya" class="text-blue-400 font-bold text-2xl">{{ $latestLog->cahaya ?? '—' }}</p>
                        <p class="text-xs text-slate-400">nilai sensor</p>
                    </div>

                    <div class="bg-slate-900 p-4 rounded-lg border border-slate-600">
                        <p class="text-xs text-slate-400 mb-1">Status</p>
                        @php $status = $latestLog->status ?? null; @endphp
                        <p id="rt-status" class="font-bold text-sm px-2 py-1 rounded inline-block mt-1
                           {{ $status==='layak'?'bg-green-600 text-white':'' }}
                           {{ $status==='tidak'?'bg-red-600 text-white':'' }}
                           {{ !$status?'text-slate-400':'' }}">
                            {{ $status ? ucfirst($status) : '—' }}
                        </p>
                        <p class="text-xs text-slate-500 mt-1">hasil deteksi</p>
                    </div>
                </div>
            </div>

            {{-- SUMMARY HARI INI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                <div class="bg-slate-800 p-6 rounded-xl border border-green-500">
                    <p class="text-sm text-slate-400">Total Produksi Hari Ini</p>
                    <h2 id="total-telur" class="text-4xl text-green-400 font-bold mt-2">{{ number_format($totalTelur ?? 0) }}</h2>
                    <p class="text-xs text-slate-400 mt-2">Total telur yang terdeteksi sensor hari ini</p>
                </div>

                <div class="bg-slate-800 p-6 rounded-xl border border-blue-500">
                    <p class="text-sm text-slate-400">Perbandingan dengan Kemarin</p>
                    <h2 id="trend-jumlah" class="text-4xl font-bold mt-2 {{($trendJumlah??0)>=0?'text-green-400':'text-red-400'}}">
                        {{($trendJumlah??0)>=0?'+':''}}{{ number_format($trendJumlah??0) }}
                    </h2>
                    <p id="trend-persen" class="text-xs mt-2 {{($trendPercent??0)>=0?'text-green-400':'text-red-400'}}">
                        {{($trendPercent??0)>=0?'↑':'↓'}} {{ abs($trendPercent??0) }}% dibanding kemarin
                    </p>
                    <p class="text-xs text-slate-500 mt-1">Kemarin: {{ number_format($yesterdayTotal ?? 0) }} telur</p>
                </div>
            </div>

            {{-- GRAFIK KLASIFIKASI HARI INI --}}
            <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 mb-8">
                <h2 class="font-bold mb-2">Klasifikasi Telur Hari Ini</h2>
                <div class="h-80"><canvas id="chart"></canvas></div>
            </div>

        </div>
    </main>
</div>

{{-- SCRIPT CHART DAN POLLING --}}
<script>
let totalLayak = {{ $totalLayak ?? 0 }};
let totalTidak = {{ $totalTidak ?? 0 }};
let totalTelur = {{ $totalTelur ?? 0 }};
const chartCanvas = document.getElementById('chart');

const klasifikasiChart = new Chart(chartCanvas, {
    type: 'bar',
    data: {
        labels: ['Layak', 'Tidak Layak'],
        datasets: [{
            label: 'Jumlah Telur',
            data: [totalLayak, totalTidak],
            backgroundColor: ['#22c55e','#ef4444'],
            borderRadius: 12,
            borderSkipped: false
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend:{display:false} },
        scales:{
            x:{ beginAtZero:true, ticks:{color:'white', precision:0}, title:{display:true,text:'Jumlah Telur',color:'white'}, grid:{color:'rgba(148,163,184,0.15)'}},
            y:{ ticks:{color:'white', font:{size:13,weight:'bold'}}, grid:{display:false} }
        }
    }
});
</script>

</body>
</html>