<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Vaksinasi - OvoSight</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white">

@php
    $jadwalMendatang = $jadwalMendatang ?? collect();
    $jadwalTerlewat = $jadwalTerlewat ?? collect();
    $jadwalSelesai = $jadwalSelesai ?? collect();

    $prevMonth = $currentMonth->copy()->subMonth();
    $nextMonth = $currentMonth->copy()->addMonth();

    $startOfMonth = $currentMonth->copy()->startOfMonth();
    $endOfMonth = $currentMonth->copy()->endOfMonth();

    $startDow = $startOfMonth->dayOfWeekIso;
    $today = \Carbon\Carbon::today();

    $totalMendatang = $jadwalMendatang->count();
    $totalTerlewat = $jadwalTerlewat->count();
    $totalSelesai = $jadwalSelesai->count();
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
               class="flex items-center px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800">
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
               class="flex items-center px-3 py-2.5 rounded-lg text-sm bg-green-600 text-white font-medium">
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
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold">Jadwal Vaksinasi</h1>
                    <p class="text-slate-400 text-sm mt-1">
                        Kelola jadwal vaksinasi ayam berdasarkan kandang dan tanggal pelaksanaan.
                    </p>
                </div>

                <a href="{{ route('jadwal.vaksinasi.create') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    + Tambah Jadwal
                </a>
            </div>

            {{-- ALERT --}}
            @if(session('success'))
                <div class="bg-green-700/30 border border-green-600 text-green-200 p-3 rounded-lg mb-5 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- SUMMARY --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-slate-800 p-4 rounded-xl border border-slate-700">
                    <p class="text-xs text-slate-400">Jadwal Belum Dilakukan</p>
                    <h2 class="text-2xl font-bold text-yellow-400 mt-1">
                        {{ number_format($totalMendatang) }}
                    </h2>
                </div>

                <div class="bg-slate-800 p-4 rounded-xl border border-slate-700">
                    <p class="text-xs text-slate-400">Jadwal Terlewat</p>
                    <h2 class="text-2xl font-bold text-red-400 mt-1">
                        {{ number_format($totalTerlewat) }}
                    </h2>
                </div>

                <div class="bg-slate-800 p-4 rounded-xl border border-slate-700">
                    <p class="text-xs text-slate-400">Jadwal Selesai</p>
                    <h2 class="text-2xl font-bold text-green-400 mt-1">
                        {{ number_format($totalSelesai) }}
                    </h2>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

                {{-- KIRI: KALENDER --}}
                <div class="xl:col-span-2">
                    <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden">

                        <div class="px-5 py-4 border-b border-slate-700 flex items-center justify-between">
                            <div>
                                <h2 class="font-bold">
                                    {{ $currentMonth->translatedFormat('F Y') }}
                                </h2>
                                <p class="text-xs text-slate-400 mt-1">
                                    Klik tanggal untuk tambah jadwal di tanggal tersebut.
                                </p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('jadwal.vaksinasi', ['bulan' => $prevMonth->month, 'tahun' => $prevMonth->year]) }}"
                                   class="bg-slate-700 hover:bg-slate-600 px-3 py-2 rounded-lg text-sm">
                                    ‹
                                </a>

                                <a href="{{ route('jadwal.vaksinasi') }}"
                                   class="bg-green-600 hover:bg-green-700 px-3 py-2 rounded-lg text-sm font-semibold">
                                    Bulan Ini
                                </a>

                                <a href="{{ route('jadwal.vaksinasi', ['bulan' => $nextMonth->month, 'tahun' => $nextMonth->year]) }}"
                                   class="bg-slate-700 hover:bg-slate-600 px-3 py-2 rounded-lg text-sm">
                                    ›
                                </a>
                            </div>
                        </div>

                        {{-- NAMA HARI --}}
                        <div class="grid grid-cols-7 bg-slate-900 text-slate-400 text-xs uppercase">
                            @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $dayName)
                                <div class="px-3 py-3 text-center font-semibold">
                                    {{ $dayName }}
                                </div>
                            @endforeach
                        </div>

                        {{-- GRID KALENDER --}}
                        <div class="grid grid-cols-7 gap-px bg-slate-700">
                            @for($i = 1; $i < $startDow; $i++)
                                <div class="min-h-[92px] bg-slate-800"></div>
                            @endfor

                            @for($day = 1; $day <= $endOfMonth->day; $day++)
                                @php
                                    $date = $currentMonth->copy()->day($day);
                                    $dateKey = $date->format('Y-m-d');
                                    $jadwalHariIni = $jadwalBulanIni->get($dateKey, collect());
                                    $isToday = $date->isSameDay($today);
                                @endphp

                                <div class="min-h-[92px] bg-slate-800 p-2 hover:bg-slate-700/70 transition">
                                    <a href="{{ route('jadwal.vaksinasi.create', ['tanggal' => $dateKey]) }}"
                                       class="inline-flex w-7 h-7 items-center justify-center rounded-full text-sm font-semibold
                                           {{ $isToday ? 'bg-green-600 text-white' : 'text-slate-300 hover:bg-slate-600' }}">
                                        {{ $day }}
                                    </a>

                                    <div class="space-y-1 mt-2">
                                        @foreach($jadwalHariIni->take(2) as $jadwal)
                                            @php
                                                $isTerlewat = $jadwal->status === 'belum'
                                                    && \Carbon\Carbon::parse($jadwal->tanggal)->lt($today);
                                            @endphp

                                            <div class="text-[11px] px-2 py-1 rounded truncate
                                                {{ $jadwal->status === 'sudah'
                                                    ? 'bg-green-600/20 text-green-300'
                                                    : ($isTerlewat
                                                        ? 'bg-red-600/20 text-red-300'
                                                        : 'bg-yellow-500/20 text-yellow-300') }}">
                                                {{ \Illuminate\Support\Str::limit($jadwal->nama_vaksin, 18) }}
                                            </div>
                                        @endforeach

                                        @if($jadwalHariIni->count() > 2)
                                            <p class="text-[11px] text-slate-400">
                                                +{{ $jadwalHariIni->count() - 2 }} jadwal
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                {{-- KANAN: DAFTAR JADWAL --}}
                <div class="space-y-5">

                    {{-- JADWAL MENDATANG --}}
                    <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-700">
                            <h2 class="font-bold">Jadwal Mendatang</h2>
                            <p class="text-xs text-slate-400 mt-1">Status belum dilakukan</p>
                        </div>

                        <div class="p-4 space-y-3 max-h-[360px] overflow-y-auto">
                            @forelse($jadwalMendatang as $jadwal)
                                <div class="bg-slate-900 border border-slate-700 rounded-lg p-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="font-semibold text-sm">{{ $jadwal->nama_vaksin }}</h3>
                                            <p class="text-xs text-slate-400 mt-1">
                                                {{ $jadwal->kandang }} • {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                                            </p>

                                            @if($jadwal->metode_pemberian)
                                                <p class="text-xs text-slate-500 mt-1">
                                                    Metode: {{ $jadwal->metode_pemberian }}
                                                </p>
                                            @endif
                                        </div>

                                        <span class="bg-yellow-500/20 text-yellow-300 px-2 py-1 rounded-full text-[11px] font-semibold">
                                            Belum
                                        </span>
                                    </div>

                                    @if($jadwal->catatan)
                                        <p class="text-xs text-slate-500 mt-2">{{ $jadwal->catatan }}</p>
                                    @endif

                                    <div class="flex gap-2 mt-3">
                                        <a href="{{ route('jadwal.vaksinasi.edit', $jadwal->id) }}"
                                           class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-300 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('jadwal.vaksinasi.selesai', $jadwal->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="bg-green-500/20 hover:bg-green-500/30 text-green-300 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Selesai
                                            </button>
                                        </form>

                                        <form method="POST"
                                              action="{{ route('jadwal.vaksinasi.destroy', $jadwal->id) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-300 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 text-center py-6">
                                    Tidak ada jadwal mendatang.
                                </p>
                            @endforelse
                        </div>
                    </div>

                    {{-- JADWAL TERLEWAT --}}
                    <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-700">
                            <h2 class="font-bold">Jadwal Terlewat</h2>
                            <p class="text-xs text-slate-400 mt-1">
                                Tanggal sudah lewat tetapi belum selesai
                            </p>
                        </div>

                        <div class="p-4 space-y-3 max-h-[300px] overflow-y-auto">
                            @forelse($jadwalTerlewat as $jadwal)
                                <div class="bg-slate-900 border border-red-500/30 rounded-lg p-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="font-semibold text-sm">{{ $jadwal->nama_vaksin }}</h3>
                                            <p class="text-xs text-slate-400 mt-1">
                                                {{ $jadwal->kandang }} • {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                                            </p>

                                            @if($jadwal->metode_pemberian)
                                                <p class="text-xs text-slate-500 mt-1">
                                                    Metode: {{ $jadwal->metode_pemberian }}
                                                </p>
                                            @endif
                                        </div>

                                        <span class="bg-red-500/20 text-red-300 px-2 py-1 rounded-full text-[11px] font-semibold">
                                            Terlewat
                                        </span>
                                    </div>

                                    @if($jadwal->catatan)
                                        <p class="text-xs text-slate-500 mt-2">{{ $jadwal->catatan }}</p>
                                    @endif

                                    <div class="flex gap-2 mt-3">
                                        <a href="{{ route('jadwal.vaksinasi.edit', $jadwal->id) }}"
                                           class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-300 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('jadwal.vaksinasi.selesai', $jadwal->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="bg-green-500/20 hover:bg-green-500/30 text-green-300 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Selesai
                                            </button>
                                        </form>

                                        <form method="POST"
                                              action="{{ route('jadwal.vaksinasi.destroy', $jadwal->id) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-300 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 text-center py-6">
                                    Tidak ada jadwal terlewat.
                                </p>
                            @endforelse
                        </div>
                    </div>

                    {{-- JADWAL SELESAI --}}
                    <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden">
                        <div class="px-5 py-4 border-b border-slate-700">
                            <h2 class="font-bold">Jadwal Selesai</h2>
                            <p class="text-xs text-slate-400 mt-1">
                                5 jadwal terakhir yang selesai
                            </p>
                        </div>

                        <div class="p-4 space-y-3">
                            @forelse($jadwalSelesai as $jadwal)
                                <div class="bg-slate-900 border border-slate-700 rounded-lg p-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="font-semibold text-sm">{{ $jadwal->nama_vaksin }}</h3>
                                            <p class="text-xs text-slate-400 mt-1">
                                                {{ $jadwal->kandang }} • {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                                            </p>
                                        </div>

                                        <span class="bg-green-500/20 text-green-300 px-2 py-1 rounded-full text-[11px] font-semibold">
                                            Sudah
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400 text-center py-6">
                                    Belum ada jadwal selesai.
                                </p>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </main>
</div>

</body>
</html>
