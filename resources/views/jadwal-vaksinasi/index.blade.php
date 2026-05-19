<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Vaksinasi - OvoSight</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-slate-900 text-white min-h-screen">

<div class="flex min-h-screen">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-60 bg-slate-950 text-white flex flex-col shrink-0">
        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-slate-800">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center text-sm font-bold">O</div>
                <span class="font-bold text-lg tracking-tight">OvoSight</span>
            </div>
        </div>

        {{-- Farm name --}}
        <div class="px-5 py-3 border-b border-slate-800">
            <p class="text-xs text-slate-400 uppercase tracking-widest">Farm</p>
            <p class="font-semibold text-sm mt-0.5">Lubada Farm</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition-all">
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
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm bg-green-600 text-white font-medium transition-all">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Jadwal Vaksinasi
            </a>
        </nav>

        {{-- Bottom links --}}
        <div class="px-3 py-4 border-t border-slate-800 space-y-0.5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-red-400 hover:bg-slate-800 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 flex flex-col min-h-screen">

        {{-- Topbar --}}
        <header class="bg-slate-950 border-b border-slate-800 px-6 py-3 flex items-center justify-between shrink-0">

            <div class="flex items-center gap-3">
                <span class="font-semibold text-white">Lubada Farm</span>
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

                <button class="relative">
                    <svg class="w-5 h-5 text-slate-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>

                    @php
                        $terlewat = \App\Models\Schedule::where('status','TERLEWAT')->count();
                    @endphp

                    @if($terlewat > 0)
                        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-500 rounded-full text-white text-[9px] flex items-center justify-center font-bold">
                            {{ $terlewat }}
                        </span>
                    @endif
                </button>

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

        {{-- Page body --}}
        <div class="flex-1 flex gap-0">

            {{-- ===== CENTER: Calendar + Form ===== --}}
            <div class="flex-1 p-6 flex flex-col gap-5 overflow-y-auto">

                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Calendar Card --}}
                <div class="bg-slate-800 rounded-2xl border border-slate-700 p-5">

                    {{-- Month nav --}}
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <h2 class="font-semibold text-slate-200 text-base">
                                {{ $currentMonth->translatedFormat('F Y') }}
                            </h2>
                        </div>

                        <div class="flex items-center gap-1">
                            @php
                                $prevMonth = $currentMonth->copy()->subMonth();
                                $nextMonth = $currentMonth->copy()->addMonth();
                            @endphp
                            <a href="{{ route('jadwal.vaksinasi', ['bulan' => $prevMonth->month, 'tahun' => $prevMonth->year]) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-900 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                            <a href="{{ route('jadwal.vaksinasi', ['bulan' => $nextMonth->month, 'tahun' => $nextMonth->year]) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-900 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Day headers --}}
                    <div class="grid grid-cols-7 mb-1">
                        @foreach(['SEN','SEL','RAB','KAM','JUM','SAB','MIN'] as $day)
                            <div class="text-center text-xs font-semibold text-slate-400 py-2">{{ $day }}</div>
                        @endforeach
                    </div>

                    {{-- Calendar grid --}}
                    @php
                        $startOfMonth   = $currentMonth->copy()->startOfMonth();
                        $endOfMonth     = $currentMonth->copy()->endOfMonth();
                        // Monday = 1 ... Sunday = 7
                        $startDow       = $startOfMonth->dayOfWeek === 0 ? 7 : $startOfMonth->dayOfWeek;
                        $today          = \Carbon\Carbon::today();
                    @endphp

                    <div class="grid grid-cols-7 gap-0.5">
                        {{-- Empty cells before month start --}}
                        @for($i = 1; $i < $startDow; $i++)
                            <div class="h-14 rounded-lg"></div>
                        @endfor

                        {{-- Days --}}
                        @for($day = 1; $day <= $endOfMonth->day; $day++)
                            @php
                                $date      = $currentMonth->copy()->setDay($day);
                                $dateKey   = $date->format('Y-m-d');
                                $hasJadwal = isset($jadwalBulanIni[$dateKey]);
                                $jadwals   = $hasJadwal ? $jadwalBulanIni[$dateKey] : collect();
                                $isToday   = $date->isSameDay($today);
                            @endphp

                            <div class="h-14 rounded-lg p-1 border {{ $isToday ? 'border-green-500 bg-slate-900' : 'border-transparent hover:border-slate-200' }} transition-all cursor-default">
                                <div class="flex items-start justify-between">
                                    <span class="text-sm font-medium {{ $isToday ? 'w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold' : 'text-slate-700' }}">
                                        {{ $day }}
                                        @if($isToday)<span class="sr-only">hari ini</span>@endif
                                    </span>
                                </div>

                                {{-- Schedule dots/chips --}}
                                @if($hasJadwal)
                                    <div class="mt-0.5 space-y-0.5">
                                        @foreach($jadwals->take(2) as $j)
                                            @php
                                                $chipColor = match($j->status) {
                                                    'SELESAI'  => 'bg-slate-200 text-slate-500',
                                                    'TERLEWAT' => 'bg-red-100 text-red-700',
                                                    default    => 'bg-green-100 text-green-700',
                                                };
                                            @endphp
                                            <div class="text-[9px] px-1 py-0.5 rounded {{ $chipColor }} truncate leading-tight font-medium">
                                                {{ Str::limit($j->nama_vaksin, 8) }}
                                            </div>
                                        @endforeach
                                        @if($jadwals->count() > 2)
                                            <div class="text-[9px] text-slate-400 px-1">+{{ $jadwals->count() - 2 }}</div>
                                        @endif
                                    </div>
                                @endif

                                @if($isToday && !$hasJadwal)
                                    <div class="flex justify-center mt-1">
                                        <span class="text-[8px] font-bold text-green-600 bg-green-900 px-1 rounded uppercase tracking-wide">Hari Ini</span>
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- ===== Form Jadwal Baru / Edit ===== --}}
                <div class="bg-slate-800 rounded-2xl border border-slate-700 p-5">

                    @if($editJadwal)
                        {{-- EDIT MODE --}}
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-1 h-5 bg-yellow-500 rounded-full"></div>
                            <h3 class="font-semibold text-slate-900">Edit Jadwal Vaksinasi</h3>
                            <span class="ml-auto text-xs text-slate-400">#{{ $editJadwal->id }}</span>
                        </div>

                        <form method="POST" action="{{ route('jadwal.vaksinasi.update', $editJadwal->id) }}">
                            @csrf
                            @method('PUT')
                            @include('jadwal-vaksinasi.form', ['jadwal' => $editJadwal, 'batches' => $batches])

                            <div class="flex gap-3 mt-5">
                                <button type="submit"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('jadwal.vaksinasi', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                                   class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-sm transition-all text-center">
                                    Batal
                                </a>
                            </div>
                        </form>

                    @else
                        {{-- CREATE MODE --}}
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-1 h-5 bg-green-500 rounded-full"></div>
                            <h3 class="font-semibold text-slate-200">Buat Jadwal Vaksinasi Baru</h3>
                        </div>

                        <form method="POST" action="{{ route('jadwal.vaksinasi.store') }}" id="form-jadwal">
                            @csrf
                            @include('jadwal-vaksinasi.form', ['jadwal' => null, 'batches' => $batches])

                            <div class="flex gap-3 mt-5">
                                <button type="button" id="btn-hapus"
                                    class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-sm transition-all">
                                    Hapus
                                </button>
                                <button type="submit"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-xl font-semibold text-sm transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Simpan Jadwal
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>

            {{-- ===== RIGHT SIDEBAR: Jadwal List ===== --}}
            <div class="w-72 bg-slate-800 border-slate-200 flex flex-col shrink-0">

                <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-200 text-sm">Jadwal Mendatang</h3>
                    <a href="{{ route('jadwal.vaksinasi') }}"
                       class="text-xs text-green-600 hover:text-green-700 font-medium">Lihat Semua</a>
                </div>

                <div class="flex-1 overflow-y-auto p-4 space-y-3">

                    {{-- Mendatang & Terlewat --}}
                    @forelse($jadwalMendatang as $jadwal)
                        @php
                            $isLewat = $jadwal->status === 'TERLEWAT';
                            $cardBorder = $isLewat ? 'border-l-4 border-l-red-500' : 'border-l-4 border-l-transparent';
                            $statusBg = $isLewat
                                ? 'bg-red-50 text-red-700 border border-red-200'
                                : 'bg-green-50 text-green-700 border border-green-200';
                            $statusLabel = $isLewat ? 'TERLEWAT' : 'TERJADWAL';
                        @endphp

                        <div class="bg-slate-900 rounded-xl border border-slate-200 {{ $cardBorder }} p-3 shadow-sm">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-slate-200 text-sm leading-tight truncate">
                                        {{ $jadwal->nama_vaksin }}
                                    </p>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $jadwal->batch_kandang }}</p>
                                </div>
                                <div class="flex items-center gap-1 shrink-0">
                                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ $statusBg }} uppercase tracking-wide">
                                        {{ $statusLabel }}
                                    </span>
                                    {{-- Edit button --}}
                                    <a href="{{ route('jadwal.vaksinasi', ['edit_id' => $jadwal->id, 'bulan' => $bulan, 'tahun' => $tahun]) }}"
                                       class="w-6 h-6 flex items-center justify-center rounded-md hover:bg-slate-100 text-slate-400 hover:text-slate-700 transition-all"
                                       title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-center gap-1 text-xs text-slate-500 mb-3">
                                <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                @if($isLewat)
                                    <span class="text-red-600 font-medium">Jatuh Tempo: {{ $jadwal->tanggal_target->format('d M Y') }}</span>
                                @else
                                    <span>Jadwal: {{ $jadwal->tanggal_target->format('d M Y') }}</span>
                                @endif
                            </div>

                            {{-- Mark done button --}}
                            <form method="POST"
                                  action="{{ route('jadwal.vaksinasi.selesai', $jadwal->id) }}">
                                @csrf
                                <button type="submit"
                                    class="w-full py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Tandai Sudah Selesai
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-xs text-slate-400">Tidak ada jadwal mendatang</p>
                        </div>
                    @endforelse

                    {{-- Selesai --}}
                    @if($jadwalSelesai->count() > 0)
                        <div class="pt-2 border-t border-slate-100">
                            @foreach($jadwalSelesai as $jadwal)
                                <div class="bg-slate-900 rounded-xl border border-slate-100 p-3 mb-2">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-slate-500 text-sm line-through truncate">
                                                {{ $jadwal->nama_vaksin }}
                                            </p>
                                            <p class="text-xs text-slate-400">{{ $jadwal->batch_kandang }}</p>
                                        </div>
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-slate-100 text-black border border-slate-200 uppercase tracking-wide shrink-0">
                                            SELESAI
                                        </span>
                                    </div>

                                    @if($jadwal->tanggal_selesai)
                                        <div class="flex items-center gap-1 text-xs text-slate-400">
                                            <svg class="w-3 h-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Selesai Pada: {{ $jadwal->tanggal_selesai->format('d M Y') }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

<script>
// Clear form button
document.getElementById('btn-hapus')?.addEventListener('click', function() {
    const form = document.getElementById('form-jadwal');
    if (!form) return;
    form.querySelectorAll('input[type="text"], input[type="date"], textarea').forEach(el => el.value = '');
    const selects = form.querySelectorAll('select');
    selects.forEach(sel => sel.selectedIndex = 0);
});
</script>

</body>
</html>
