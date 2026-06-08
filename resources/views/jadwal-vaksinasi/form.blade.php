{{--
    Partial form Jadwal Vaksinasi
    Dipakai untuk create dan edit.
    $jadwal = null untuk tambah data.
    $jadwal berisi data Schedule untuk edit.
--}}

@php
    $jadwal = $jadwal ?? null;
@endphp

<div class="grid grid-cols-2 gap-4">

    {{-- NAMA VAKSIN --}}
    <div class="col-span-2 sm:col-span-1">
        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">
            Nama Vaksin
        </label>

        <input type="text"
               name="nama_vaksin"
               value="{{ old('nama_vaksin', $jadwal?->nama_vaksin) }}"
               placeholder="Contoh: Newcastle Disease (ND)"
               class="w-full px-3 py-2.5 text-sm bg-slate-700 text-white border border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all placeholder:text-slate-400">

        @error('nama_vaksin')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- KANDANG --}}
    <div class="col-span-2 sm:col-span-1">
        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">
            Kandang
        </label>

        <input type="text"
               name="kandang"
               value="{{ old('kandang', $jadwal?->kandang) }}"
               placeholder="Contoh: KDG-001"
               class="w-full px-3 py-2.5 text-sm bg-slate-700 text-white border border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all placeholder:text-slate-400">

        <p class="text-xs text-slate-500 mt-1">
            Masukkan ID kandang secara manual.
        </p>

        @error('kandang')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- TANGGAL --}}
    <div>
        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">
            Tanggal
        </label>

        <input type="date"
               name="tanggal"
               value="{{ old('tanggal', $jadwal?->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d') : '') }}"
               class="w-full px-3 py-2.5 text-sm bg-white text-slate-900 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">

        @error('tanggal')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- METODE PEMBERIAN --}}
    <div>
        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">
            Metode Pemberian
        </label>

        <div class="relative">
            <select name="metode_pemberian"
                    class="w-full px-3 py-2.5 text-sm bg-slate-700 text-white border border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none transition-all">

                <option value="">Pilih metode</option>

                @foreach(['Air Minum', 'Suntik', 'Tetes Mata', 'Semprot', 'Oral'] as $metode)
                    <option value="{{ $metode }}"
                        {{ old('metode_pemberian', $jadwal?->metode_pemberian ?? 'Air Minum') === $metode ? 'selected' : '' }}>
                        {{ $metode }}
                    </option>
                @endforeach
            </select>

            <svg class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        @error('metode_pemberian')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- STATUS HANYA MUNCUL SAAT EDIT --}}
    @if($jadwal)
        <div>
            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">
                Status
            </label>

            <div class="relative">
                <select name="status"
                        class="w-full px-3 py-2.5 text-sm bg-slate-700 text-white border border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none transition-all">

                    <option value="belum" {{ old('status', $jadwal->status) === 'belum' ? 'selected' : '' }}>
                        Belum
                    </option>

                    <option value="sudah" {{ old('status', $jadwal->status) === 'sudah' ? 'selected' : '' }}>
                        Sudah
                    </option>
                </select>

                <svg class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </div>

            @error('status')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    @endif

    {{-- CATATAN --}}
    <div class="col-span-2">
        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1.5">
            Catatan
        </label>

        <textarea name="catatan"
                  rows="3"
                  placeholder="Catatan tambahan jika diperlukan"
                  class="w-full px-3 py-2.5 text-sm bg-slate-700 text-white border border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all placeholder:text-slate-400">{{ old('catatan', $jadwal?->catatan) }}</textarea>

        @error('catatan')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>