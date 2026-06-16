<x-app-layout>
    <x-slot name="header">
        Form Input Laporan Harian Tambang
    </x-slot>

    <div class="max-w-5xl mx-auto py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-md font-bold text-gray-700 uppercase tracking-tight">Form Input Laporan Harian Tambang</h3>
            </div>

            @if(session('success'))
                <div class="px-6 pt-4">
                    <div class="flex items-center p-4 mb-4 text-emerald-800 border-t-4 border-emerald-300 bg-emerald-50 rounded-lg" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ml-3 text-sm font-bold uppercase tracking-wide">
                            {{ session('success') }}
                        </div>
                        <button type="button" @click="open = false" class="ml-auto -mx-1.5 -my-1.5 bg-emerald-50 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerald-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-border-3" aria-label="Close">
                            <span class="sr-only">Dismiss</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
            
            <form action="{{ route('laporan.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Shift <span class="text-red-500">*</span></label>
                        <select name="shift" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="Shift 1">Shift 1</option>
                            <option value="Shift 2">Shift 2</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Lokasi Tambang <span class="text-red-500">*</span></label>
                        <select name="lokasi_tambang_id" required class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach($lokasiTambang as $lokasi)
                                <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div x-data="{ 
                        alatTerpilih: '{{ $alatTambang->first()->id ?? '' }}', 
                        namaAlat: '{{ $alatTambang->first()->nama_alat ?? 'Pilih Alat' }}',
                        tipeAlat: '{{ $alatTambang->first()->tipe_alat ?? '' }}',
                        /* Default gambar: ambil dari database jika ada, jika tidak pakai icon default */
                        gambarAlat: '{{ isset($alatTambang->first()->gambar) && $alatTambang->first()->gambar ? asset('storage/' . $alatTambang->first()->gambar) : asset('truck-icon.svg') }}',
                        dropdownBuka: false 
                    }" class="relative">
                        
                        <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">
                            Alat Berat <span class="text-red-500">*</span>
                        </label>
                        
                        <input type="hidden" name="alat_tambang_id" x-model="alatTerpilih">

                        <div class="flex items-center justify-between p-2.5 border border-gray-200 rounded-lg bg-white shadow-sm hover:border-[#509673] transition">
                            
                            <div class="flex items-center gap-4">
                                <div class="bg-gray-50 p-2 rounded-md border border-gray-100 flex-shrink-0">
                                    <img :src="gambarAlat" class="w-8 h-8 object-cover opacity-80" alt="Icon Alat">
                                </div>
                                
                                <div class="flex flex-col truncate">
                                    <div class="text-[14px] font-bold text-[#1e293b] flex flex-wrap gap-1 items-center">
                                        <span x-text="namaAlat" class="truncate max-w-[200px]"></span>
                                        <span class="font-normal text-gray-500 text-xs truncate" x-text="tipeAlat ? '(' + tipeAlat + ')' : ''"></span>
                                    </div>
                                    <div class="text-[10px] font-bold text-gray-400 mt-0.5 tracking-wider uppercase">UNIT READY • 1 243 COL</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pr-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                
                                <button type="button" @click="dropdownBuka = !dropdownBuka" class="bg-[#509673] hover:bg-[#3f7b5d] text-white px-3.5 py-1.5 rounded-md text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    EDIT
                                </button>
                            </div>
                        </div>

                        <div x-show="dropdownBuka" 
                            @click.away="dropdownBuka = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-y-auto"
                            style="display: none;">
                            
                            <ul class="py-1">
                                @foreach($alatTambang as $alat)
                                <li>
                                    <button type="button" 
                                            @click="
                                                alatTerpilih = '{{ $alat->id }}'; 
                                                namaAlat = '{{ addslashes($alat->nama_alat) }}'; 
                                                tipeAlat = '{{ addslashes($alat->tipe_alat) }}'; 
                                                /* Update gambar berdasarkan pilihan */
                                                gambarAlat = '{{ $alat->gambar ? asset('storage/' . $alat->gambar) : asset('truck-icon.svg') }}';
                                                dropdownBuka = false;
                                            "
                                            class="w-full flex items-center gap-3 text-left px-4 py-3 hover:bg-gray-50 focus:bg-gray-50 focus:outline-none transition border-b border-gray-50 last:border-b-0">
                                        
                                        <img src="{{ $alat->gambar ? asset('storage/' . $alat->gambar) : asset('truck-icon.svg') }}" class="w-8 h-8 rounded object-cover border border-gray-100" alt="img">
                                        
                                        <div>
                                            <div class="font-bold text-gray-800 text-sm">{{ $alat->nama_alat }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $alat->tipe_alat }}</div>
                                        </div>
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Operator <span class="text-emerald-500">●</span></label>
                        <input type="text" readonly value="{{ auth()->user()->nama_lengkap }}" class="w-full px-4 py-2 border border-gray-200 rounded-md bg-gray-100 text-gray-500 text-sm cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Admin Pengawas</label>
                        <input type="text" readonly value="Agus Wijaya" class="w-full px-4 py-2 border border-gray-200 rounded-md bg-gray-100 text-gray-500 text-sm cursor-not-allowed">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-gray-100 pt-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Material <span class="text-red-500">*</span></label>
                        <select name="material" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                            <option value="Overburden">Overburden (OB)</option>
                            <option value="Batu Bara">Batu Bara</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Volume [BCM/Ton] <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="volume" required placeholder="2500" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jarak Angkut [m] <span class="text-emerald-500">●</span></label>
                        <input type="number" name="jarak" required placeholder="1500" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-white focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jam Kerja <span class="text-emerald-500">●</span></label>
                        <select name="jam_operasi" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="8">8 Jam</option>
                            <option value="12">12 Jam</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Konsumsi BBM [L] <span class="text-red-500">*</span></label>
                        <input type="number" name="bahan_bakar" placeholder="220" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-gray-100 pt-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan" rows="2" placeholder="Catatan tambahan atau kendala lapangan..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 focus:border-emerald-500 text-sm"></textarea>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kondisi Cuaca <span class="text-emerald-500">●</span></label>
                            <select name="cuaca" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="Cerah">Cerah</option>
                                <option value="Hujan">Hujan</option>
                                <option value="Berawan">Berawan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Hambatan Operasional</label>
                            <select name="hambatan" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm font-bold text-emerald-600 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="Tidak Ada">TIDAK ADA</option>
                                <option value="Breakdown">BREAKDOWN</option>
                                <option value="Slippery">SLIPPERY</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex gap-4">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-10 py-2 rounded-md font-bold text-sm shadow-sm transition">
                        Simpan
                    </button>
                    <button type="reset" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-10 py-2 rounded-md font-bold text-sm transition">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>