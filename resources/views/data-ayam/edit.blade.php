<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Ayam</title>
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
               class="flex items-center px-3 py-2.5 rounded-lg text-sm bg-green-600 text-white font-medium">
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
                <h1 class="text-2xl font-bold">Edit Data Ayam</h1>
                <p class="text-slate-400 text-sm mt-1">
                    Perbarui data ayam berdasarkan ID kandang dan tanggal masuk.
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

            {{-- FORM CARD --}}
            <div class="bg-slate-800 rounded-xl border border-slate-700 max-w-3xl overflow-hidden">

                <div class="px-5 py-4 border-b border-slate-700">
                    <h2 class="font-bold">Form Edit Data Ayam</h2>
                    <p class="text-xs text-slate-400 mt-1">
                        Umur dihitung otomatis dari tanggal masuk. Status Afkir jika umur di atas 100 minggu.
                    </p>
                </div>

                <form action="{{ route('data.ayam.update', $batch->id) }}"
                      method="POST"
                      class="p-5 space-y-5">

                    @csrf
                    @method('PUT')

                    {{-- ID KANDANG --}}
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">
                            ID Kandang
                        </label>

                        <input type="text"
                               name="id_kandang"
                               value="{{ old('id_kandang', $batch->id_kandang) }}"
                               placeholder="Contoh: KDG-001"
                               class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

                        <p class="text-xs text-slate-500 mt-1">
                            ID kandang digunakan sebagai identitas utama data ayam.
                        </p>
                    </div>

                    {{-- TANGGAL MASUK --}}
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">
                            Tanggal Masuk
                        </label>

                        <input type="date"
                               name="tanggal_masuk"
                               value="{{ old('tanggal_masuk', $batch->tanggal_masuk ? \Carbon\Carbon::parse($batch->tanggal_masuk)->format('Y-m-d') : '') }}"
                               class="w-full bg-white text-slate-900 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

                        <p class="text-xs text-slate-500 mt-1">
                            Umur ayam saat ini:
                            <span class="text-yellow-400 font-semibold">
                                {{ $batch->umur_minggu }} minggu
                            </span>.
                            Umur akan berubah otomatis setiap minggu.
                        </p>
                    </div>

                    {{-- POPULASI --}}
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">
                            Populasi
                        </label>

                        <input type="text"
                            name="populasi"
                            value="{{ old('populasi', $batch->populasi) }}"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            placeholder="Contoh: 2500"
                            class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">

                        <p class="text-xs text-slate-500 mt-1">
                            Masukkan jumlah ayam dalam satu kandang.
                        </p>
                    </div>

                    {{-- ACTION --}}
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-400 text-black px-4 py-2 rounded-lg text-sm font-semibold">
                            Update
                        </button>

                        <a href="{{ route('data.ayam') }}"
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
