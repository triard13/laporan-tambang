<x-app-layout>
    <x-slot name="header">
        Edit Laporan Harian Tambang
    </x-slot>

    <div class="max-w-5xl mx-auto py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-amber-50/50">
                <h3 class="text-md font-bold text-amber-700 uppercase tracking-tight">Edit Laporan Harian - #{{ $laporan->id }}</h3>
            </div>

            <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <input type="date" name="tanggal" value="{{ $laporan->tanggal }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-emerald-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Shift</label>
                        <select name="shift" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm">
                            <option value="Shift 1" {{ $laporan->shift == 'Shift 1' ? 'selected' : '' }}>Shift 1</option>
                            <option value="Shift 2" {{ $laporan->shift == 'Shift 2' ? 'selected' : '' }}>Shift 2</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Lokasi Tambang</label>
                        <select name="lokasi" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm">
                            <option value="Blok A" {{ $laporan->lokasi == 'Blok A' ? 'selected' : '' }}>Blok A</option>
                            <option value="Blok B" {{ $laporan->lokasi == 'Blok B' ? 'selected' : '' }}>Blok B</option>
                            <option value="Blok C" {{ $laporan->lokasi == 'Blok C' ? 'selected' : '' }}>Blok C</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Alat Berat</label>
                        <div class="flex items-center gap-2 p-2 border border-gray-300 rounded-md bg-gray-50">
                            <div class="bg-white p-1 rounded border shadow-sm">
                                <img src="https://cdn-icons-png.flaticon.com/512/2345/2345437.png" class="w-8 h-8 opacity-75" alt="Icon">
                            </div>
                            <div class="flex-1 min-w-0">
                                <select name="alat_tambang_id" class="w-full border-none bg-transparent p-0 focus:ring-0 text-sm font-bold text-gray-700">
                                    @foreach($alats as $alat)
                                        <option value="{{ $alat->id }}" {{ $laporan->alat_tambang_id == $alat->id ? 'selected' : '' }}>
                                            {{ $alat->nama_alat }} ({{ $alat->tipe_alat }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Produksi OB [BCM]</label>
                            <input type="number" name="volume" value="{{ $laporan->volume }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Jam Kerja</label>
                            <select name="jam_operasi" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm">
                                <option value="8" {{ $laporan->jam_operasi == 8 ? 'selected' : '' }}>8 Jam</option>
                                <option value="12" {{ $laporan->jam_operasi == 12 ? 'selected' : '' }}>12 Jam</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Jarak Angkut [m]</label>
                            <select name="jarak" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm">
                                <option value="500" {{ $laporan->jarak_angkut == 500 ? 'selected' : '' }}>500 m</option>
                                <option value="1000" {{ $laporan->jarak_angkut == 1000 ? 'selected' : '' }}>1000 m</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Konsumsi BBM [L]</label>
                            <input type="number" name="bahan_bakar" value="{{ $laporan->bahan_bakar }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 text-sm">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Catatan Tambahan</label>
                        <textarea name="catatan" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 text-sm">{{ $laporan->catatan_tambahan }}</textarea>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kondisi Cuaca</label>
                            <select name="cuaca" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm">
                                <option value="Cerah" {{ $laporan->cuaca == 'Cerah' ? 'selected' : '' }}>Cerah</option>
                                <option value="Hujan" {{ $laporan->cuaca == 'Hujan' ? 'selected' : '' }}>Hujan</option>
                                <option value="Berawan" {{ $laporan->cuaca == 'Berawan' ? 'selected' : '' }}>Berawan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Hambatan Operasional</label>
                            <select name="hambatan" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm font-bold text-emerald-600">
                                <option value="Tidak Ada" {{ $laporan->hambatan_operasional == 'Tidak Ada' ? 'selected' : '' }}>TIDAK ADA</option>
                                <option value="Breakdown" {{ $laporan->hambatan_operasional == 'Breakdown' ? 'selected' : '' }}>BREAKDOWN</option>
                                <option value="Slippery" {{ $laporan->hambatan_operasional == 'Slippery' ? 'selected' : '' }}>SLIPPERY</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex gap-4">
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-10 py-2 rounded-md font-bold text-sm shadow-sm transition">
                        Update Laporan
                    </button>
                    <a href="{{ route('laporan.riwayat') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-10 py-2 rounded-md font-bold text-sm transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>