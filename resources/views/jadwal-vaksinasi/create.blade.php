<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Vaksinasi - OvoSight</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 text-white overflow-x-hidden">

<div id="sidebar-overlay"
     class="fixed inset-0 bg-black/60 z-40 hidden lg:hidden"></div>

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
           class="fixed lg:static inset-y-0 left-0 z-50 w-64 lg:w-60 bg-slate-950 text-white flex flex-col shrink-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">

        <div class="px-5 py-5 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center text-sm font-bold">
                    O
                </div>
                <span class="font-bold text-lg tracking-tight">OvoSight</span>
            </div>

            <button type="button"
                    id="close-sidebar"
                    class="lg:hidden text-slate-400 hover:text-white text-2xl leading-none">
                &times;
            </button>
        </div>

        <div class="px-5 py-3 border-b border-slate-800">
            <p class="text-xs text-slate-400 uppercase tracking-widest">Farm</p>
            <p class="font-semibold text-sm mt-0.5">Lubada Farm</p>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
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
    <main class="flex-1 flex flex-col min-w-0 w-full">

        {{-- TOPBAR --}}
        <header class="bg-slate-950 border-b border-slate-800 px-4 sm:px-6 py-3 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <button type="button"
                        id="open-sidebar"
                        class="lg:hidden w-9 h-9 rounded-lg bg-slate-800 hover:bg-slate-700 flex items-center justify-center text-white">
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

        <div class="p-4 sm:p-5 min-w-0">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Tambah Jadwal Vaksinasi</h1>
                <p class="text-slate-400 text-sm mt-1">
                    Tambahkan jadwal vaksinasi baru dengan kandang input manual.
                </p>
            </div>

            @if($errors->any())
                <div class="bg-red-600/20 border border-red-500 text-red-200 p-4 rounded-lg mb-5 text-sm">
                    <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-slate-800 rounded-xl border border-slate-700 w-full max-w-3xl overflow-hidden">
                <div class="px-4 sm:px-5 py-4 border-b border-slate-700">
                    <h2 class="font-bold">Form Tambah Jadwal Vaksinasi</h2>
                    <p class="text-xs text-slate-400 mt-1">
                        Kandang diisi manual menggunakan input text.
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('jadwal.vaksinasi.store') }}"
                      class="p-4 sm:p-5 space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-slate-400 mb-1">Nama Vaksin</label>
                            <input type="text"
                                   name="nama_vaksin"
                                   value="{{ old('nama_vaksin') }}"
                                   placeholder="Contoh: Newcastle Disease"
                                   class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500">
                            @error('nama_vaksin')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs text-slate-400 mb-1">Kandang</label>
                            <input type="text"
                                   name="kandang"
                                   value="{{ old('kandang') }}"
                                   placeholder="Contoh: KDG-001"
                                   class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500">
                            @error('kandang')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs text-slate-400 mb-1">Tanggal</label>
                            <input type="date"
                                   name="tanggal"
                                   value="{{ old('tanggal', $tanggal ?? '') }}"
                                   class="w-full bg-white text-slate-900 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                            @error('tanggal')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs text-slate-400 mb-1">Metode Pemberian</label>
                            <select name="metode_pemberian"
                                    class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="">Pilih metode</option>
                                @foreach(['Air Minum', 'Suntik', 'Tetes Mata', 'Semprot', 'Oral'] as $metode)
                                    <option value="{{ $metode }}" {{ old('metode_pemberian', 'Air Minum') === $metode ? 'selected' : '' }}>
                                        {{ $metode }}
                                    </option>
                                @endforeach
                            </select>
                            @error('metode_pemberian')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs text-slate-400 mb-1">Catatan</label>
                            <textarea name="catatan"
                                      rows="3"
                                      placeholder="Catatan tambahan jika diperlukan"
                                      class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-3 py-2 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button type="submit"
                                class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                            Simpan Jadwal
                        </button>

                        <a href="{{ route('jadwal.vaksinasi') }}"
                           class="w-full sm:w-auto text-center bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-white text-sm font-semibold">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </main>
</div>

<script>
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
