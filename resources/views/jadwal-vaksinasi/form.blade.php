{{--
    Partial form for both create and edit.
    $jadwal = null for create, JadwalVaksinasi instance for edit.
    $batches = array of batch names.
--}}

<div class="grid grid-cols-2 gap-4">

    {{-- Nama Vaksin --}}
    <div class="col-span-2 sm:col-span-1">
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
            NAMA VAKSIN
        </label>
        <input type="text"
               name="nama_vaksin"
               value="{{ old('nama_vaksin', $jadwal?->nama_vaksin) }}"
               placeholder="contoh: Newcastle Disease (ND)"
               class="w-full px-3 py-2.5 text-sm bg-slate-900 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all placeholder:text-slate-300"/>
        @error('nama_vaksin')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Batch / Kandang --}}
    <div class="col-span-2 sm:col-span-1">
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
            BATCH / KANDANG
        </label>
        <div class="relative">
            <select name="batch_kandang"
                    class="w-full px-3 py-2.5 text-sm bg-slate-900 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none transition-all">
                <option value="">-- Pilih Batch --</option>
                @foreach($batches as $b)
                    <option value="{{ $b }}"
                        {{ old('batch_kandang', $jadwal?->batch_kandang) === $b ? 'selected' : '' }}>
                        {{ $b }}
                    </option>
                @endforeach
            </select>
            <svg class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        @error('batch_kandang')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tanggal Target --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
            TANGGAL TARGET
        </label>
        <input type="date"
               name="tanggal_target"
               value="{{ old('tanggal_target', $jadwal?->tanggal_target?->format('Y-m-d')) }}"
               class="w-full px-3 py-2.5 text-sm bg-slate-900 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"/>
        @error('tanggal_target')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Metode Pemberian --}}
    <div>
        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">
            METODE PEMBERIAN
        </label>
        <div class="relative">
            <select name="metode_pemberian"
                    class="w-full px-3 py-2.5 text-sm bg-slate-900 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent appearance-none transition-all">
                @foreach(['Air Minum', 'Suntik', 'Tetes Mata', 'Semprot', 'Oral'] as $metode)
                    <option value="{{ $metode }}"
                        {{ old('metode_pemberian', $jadwal?->metode_pemberian ?? 'Air Minum') === $metode ? 'selected' : '' }}>
                        {{ $metode }}
                    </option>
                @endforeach
            </select>
            <svg class="w-4 h-4 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        @error('metode_pemberian')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>
