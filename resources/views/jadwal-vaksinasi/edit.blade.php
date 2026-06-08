<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal Vaksinasi - OvoSight</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white">

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
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Edit Jadwal Vaksinasi</h1>
                <p class="text-slate-400 text-sm mt-1">
                    Perbarui nama vaksin, kandang, tanggal, metode, status, dan catatan jadwal vaksinasi.
                </p>
            </div>

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="bg-red-600/20 border border-red-500 text-red-200 p-4 rounded-lg mb-6 text-sm">
                    <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $tanggalJadwal = \Carbon\Carbon::parse($jadwal->tanggal);
                $isTerlewat = $jadwal->status === 'belum' && $tanggalJadwal->lt(\Carbon\Carbon::today());
            @endphp

            {{-- INFO STATUS SAAT INI --}}
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-4 mb-5 max-w-3xl">
                <p class="text-xs text-slate-400 mb-2">Status saat ini</p>

                @if($jadwal->status === 'sudah')
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-300">
                        Sudah
                    </span>
                @elseif($isTerlewat)
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-300">
                        Terlewat
                    </span>
                    <p class="text-xs text-slate-500 mt-2">
                        Status terlewat muncul otomatis karena jadwal masih belum dilakukan dan tanggalnya sudah lewat.
                    </p>
                @else
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/20 text-yellow-300">
                        Belum
                    </span>
                @endif
            </div>

            {{-- FORM CARD --}}
            <div class="bg-slate-800 rounded-xl border border-slate-700 max-w-3xl overflow-hidden">

                <div class="px-5 py-4 border-b border-slate-700">
                    <h2 class="font-bold">Form Edit Jadwal</h2>
                    <p class="text-xs text-slate-400 mt-1">
                        Status hanya bisa dipilih belum atau sudah. Terlewat dihitung otomatis dari tanggal.
                    </p>
                </div>

                <form action="{{ route('jadwal.vaksinasi.update', $jadwal->id) }}"
                      method="POST"
                      class="p-5 space-y-5">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- NAMA VAKSIN --}}
                        <div>
                            <label class="block text-sm text-slate-300 mb-1">
                                Nama Vaksin
                            </label>

                            <input type="text"
                                   name="nama_vaksin"
                                   value="{{ old('nama_vaksin', $jadwal->nama_vaksin) }}"
                                   placeholder="Contoh: Newcastle Disease"
                                   class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500">

                            @error('nama_vaksin')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- KANDANG --}}
                        <div>
                            <label class="block text-sm text-slate-300 mb-1">
                                Kandang
                            </label>

                            <input type="text"
                                   name="kandang"
                                   value="{{ old('kandang', $jadwal->kandang) }}"
                                   placeholder="Contoh: KDG-001"
                                   class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500">

                            @error('kandang')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- TANGGAL --}}
                        <div>
                            <label class="block text-sm text-slate-300 mb-1">
                                Tanggal
                            </label>

                            <input type="date"
                                   name="tanggal"
                                   value="{{ old('tanggal', \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d')) }}"
                                   class="w-full bg-white text-slate-900 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

                            @error('tanggal')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- METODE PEMBERIAN --}}
                        <div>
                            <label class="block text-sm text-slate-300 mb-1">
                                Metode Pemberian
                            </label>

                            <select name="metode_pemberian"
                                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">Pilih metode</option>

                                @foreach(['Air Minum', 'Suntik', 'Tetes Mata', 'Semprot', 'Oral'] as $metode)
                                    <option value="{{ $metode }}"
                                        {{ old('metode_pemberian', $jadwal->metode_pemberian) === $metode ? 'selected' : '' }}>
                                        {{ $metode }}
                                    </option>
                                @endforeach
                            </select>

                            @error('metode_pemberian')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- STATUS --}}
                        <div>
                            <label class="block text-sm text-slate-300 mb-1">
                                Status
                            </label>

                            <select name="status"
                                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="belum" {{ old('status', $jadwal->status) === 'belum' ? 'selected' : '' }}>
                                    Belum
                                </option>

                                <option value="sudah" {{ old('status', $jadwal->status) === 'sudah' ? 'selected' : '' }}>
                                    Sudah
                                </option>
                            </select>

                            <p class="text-xs text-slate-500 mt-1">
                                Pilih sudah jika vaksinasi sudah dilakukan.
                            </p>

                            @error('status')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- CATATAN --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm text-slate-300 mb-1">
                                Catatan
                            </label>

                            <textarea name="catatan"
                                      rows="3"
                                      placeholder="Catatan tambahan jika diperlukan"
                                      class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('catatan', $jadwal->catatan) }}</textarea>

                            @error('catatan')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-400 text-black px-4 py-2 rounded-lg text-sm font-semibold">
                            Update Jadwal
                        </button>

                        <a href="{{ route('jadwal.vaksinasi', [
                                'bulan' => \Carbon\Carbon::parse($jadwal->tanggal)->month,
                                'tahun' => \Carbon\Carbon::parse($jadwal->tanggal)->year
                            ]) }}"
                           class="bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-white text-sm font-semibold">
                            Kembali
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </main>

</div>

</body>
</html>
