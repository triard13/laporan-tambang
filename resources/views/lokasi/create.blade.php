<x-app-layout>
    <x-slot name="header">
        Tambah Lokasi Tambang Baru
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
            
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-md font-bold text-gray-700 uppercase tracking-tight">Borang Tambah Lokasi</h3>
                <a href="{{ route('manajemen.lokasi') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                    &larr; Kembali
                </a>
            </div>

            <form action="{{ route('lokasi.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Lokasi / Blok <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lokasi" value="{{ old('nama_lokasi') }}" required placeholder="Contoh: Blok A" 
                               class="w-full px-4 py-2 border @error('nama_lokasi') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-emerald-500 text-sm">
                        @error('nama_lokasi') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Penanggung Jawab (Koordinator) <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <select name="koordinator" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 text-sm bg-white">
                            <option value="">-- Pilih Penanggung Jawab --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->nama_lengkap }}" {{ old('koordinator') == $user->nama_lengkap ? 'selected' : '' }}>
                                    {{ $user->nama_lengkap }} - ({{ $user->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Koordinat (Titik Tengah) <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="koordinat" value="{{ old('koordinat') }}" placeholder="Contoh: -3.2178, 115.5604" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 text-sm font-mono text-gray-600">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Luas Area <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <div class="flex items-center">
                            <input type="number" name="luas_area" value="{{ old('luas_area') }}" placeholder="Contoh: 50" min="0" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-l-md focus:ring-emerald-500 text-sm border-r-0">
                            <span class="px-4 py-2 bg-gray-50 border border-gray-300 rounded-r-md text-sm text-gray-500 font-bold uppercase">Hektar</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex gap-4">
                    <button type="submit" class="p-2 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-2.5 rounded-md font-bold text-sm shadow-sm transition">
                        Simpan Lokasi
                    </button>
                    <button type="reset" class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-8 py-2.5 rounded-md font-bold text-sm transition text-center">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>