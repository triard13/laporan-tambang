<x-app-layout>
    <x-slot name="header">
        Form Input Laporan Harian Tambang
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            @if(session('success'))
                <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <form action="{{ route('laporan.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Shift <span class="text-red-500">*</span></label>
                        <select name="shift" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            <option value="Shift 1">Shift 1</option>
                            <option value="Shift 2">Shift 2</option>
                            <option value="Shift 3">Shift 3</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lokasi Tambang <span class="text-red-500">*</span></label>
                        <select name="lokasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            <option value="Blok A">Blok A</option>
                            <option value="Blok B">Blok B</option>
                            <option value="Blok C">Blok C</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alat Berat <span class="text-red-500">*</span></label>
                        <select name="alat_tambang_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            <option value="">-- Pilih Alat Berat --</option>
                            @foreach($alatTambang as $alat)
                                <option value="{{ $alat->id }}">{{ $alat->nama_alat }} ({{ $alat->tipe_alat }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Operator <span class="text-red-500">*</span></label>
                        <input type="text" readonly value="{{ Auth::user()->nama_lengkap }}" class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm sm:text-sm">
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Material <span class="text-red-500">*</span></label>
                        <input type="text" name="material" placeholder="Misal: Overburden" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Volume Produksi [BCM] <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="volume" placeholder="2500" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jam Kerja <span class="text-red-500">*</span></label>
                        <select name="jam_operasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}">{{ $i }} Jam</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Konsumsi BBM [Liter] <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="bahan_bakar" placeholder="220" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Hambatan Operasional (Opsional)</label>
                        <select name="jenis_hambatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Tidak Ada</option>
                            <option value="Kerusakan Alat">Kerusakan Alat</option>
                            <option value="Cuaca Buruk">Cuaca Buruk (Hujan/Licin)</option>
                            <option value="Menunggu Antrian">Menunggu Antrian</option>
                        </select>
                    </div>

                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">Catatan Tambahan (Opsional)</label>
                    <textarea name="keterangan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Catatan tambahan atau kendala lapangan..."></textarea>
                </div>

                <div class="mt-6 flex items-center justify-start gap-4">
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Simpan
                    </button>
                    <button type="reset" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-6 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Reset
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>