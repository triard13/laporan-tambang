<x-app-layout>
    <x-slot name="header">
        Edit Data Alat Berat
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
            
            <div class="px-8 py-5 border-b border-gray-100 bg-blue-50/50 flex justify-between items-center">
                <h3 class="text-md font-bold text-blue-700 uppercase tracking-tight">Edit Alat: {{ $alat->kode_alat ?? $alat->nama_alat }}</h3>
                <a href="{{ route('manajemen.alat') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                    &larr; Batal & Kembali
                </a>
            </div>

            <form action="{{ route('alat.update', $alat->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kode Alat <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_alat" value="{{ old('kode_alat', $alat->kode_alat) }}" required 
                               class="w-full px-4 py-2 border @error('kode_alat') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-blue-500 text-sm">
                        @error('kode_alat') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Alat <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}" required 
                               class="w-full px-4 py-2 border @error('nama_alat') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-blue-500 text-sm">
                        @error('nama_alat') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jenis/Tipe Alat <span class="text-red-500">*</span></label>
                        <input type="text" name="tipe_alat" value="{{ old('tipe_alat', $alat->tipe_alat) }}" required 
                               class="w-full px-4 py-2 border @error('tipe_alat') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kapasitas <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="kapasitas" value="{{ old('kapasitas', $alat->kapasitas) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jam Kerja Terkini <span class="text-red-500">*</span></label>
                        <input type="number" name="jam_kerja" value="{{ old('jam_kerja', $alat->jam_kerja) }}" required min="0" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Status Operasi <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 text-sm font-bold text-gray-700 bg-gray-50">
                            <option value="Aktif" {{ old('status', $alat->status) == 'Aktif' ? 'selected' : '' }}>Aktif (Beroperasi)</option>
                            <option value="Perawatan" {{ old('status', $alat->status) == 'Perawatan' ? 'selected' : '' }}>Perawatan (Maintenance)</option>
                            <option value="Rusak" {{ old('status', $alat->status) == 'Rusak' ? 'selected' : '' }}>Rusak (Breakdown)</option>
                        </select>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 border-dashed flex gap-6 items-start">
                    <div class="w-16 h-16 bg-white border border-gray-200 rounded flex-shrink-0 flex items-center justify-center overflow-hidden">
                        @if($alat->gambar)
                            <img src="{{ asset('storage/'.$alat->gambar) }}" alt="Preview" class="w-full h-full object-contain">
                        @else
                            <div class="text-center">
                                <svg class="w-6 h-6 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-[9px] text-gray-400 block mt-1">No Image</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Ganti Gambar Alat <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="file" name="gambar" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-md text-sm bg-white focus:ring-blue-500">
                        <p class="text-[10px] text-gray-400 mt-2">Biarkan kosong jika tidak ingin mengganti gambar. Format: JPG, PNG (Maks 2MB).</p>
                        @error('gambar') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex gap-4">
                    <button type="submit" class="p-2 bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-md font-bold text-sm shadow-sm transition">
                        Update Data Alat
                    </button>
                    <a href="{{ route('manajemen.alat') }}" class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-8 py-2.5 rounded-md font-bold text-sm transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>