<x-app-layout>
    <x-slot name="header">Tambah Alat Berat Baru</x-slot>

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

    <div class="max-w-4xl mx-auto py-6 px-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
            <div class="flex justify-between items-center mb-6 pb-4 border-b">
                <h3 class="font-bold text-gray-700 uppercase">Borang Tambah Alat</h3>
                <a href="{{ route('manajemen.alat') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali</a>
            </div>

            <form action="{{ route('alat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kod Alat *</label>
                        <input type="text" name="kode_alat" value="{{ old('kode_alat') }}" required placeholder="Cth: Exca-01" class="w-full px-4 py-2 border rounded-md text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Alat *</label>
                        <input type="text" name="nama_alat" value="{{ old('nama_alat') }}" required placeholder="Cth: CAT 320D" class="w-full px-4 py-2 border rounded-md text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jenis Alat *</label>
                        <input type="text" name="tipe_alat" value="{{ old('tipe_alat') }}" required placeholder="Cth: Excavator" class="w-full px-4 py-2 border rounded-md text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kapasiti (Opsional)</label>
                        <input type="text" name="kapasitas" value="{{ old('kapasitas') }}" placeholder="Cth: 1,243 BCM" class="w-full px-4 py-2 border rounded-md text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jam Kerja Terkini *</label>
                        <input type="number" name="jam_kerja" value="{{ old('jam_kerja', 0) }}" required class="w-full px-4 py-2 border rounded-md text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Status Operasi *</label>
                        <select name="status" class="w-full px-4 py-2 border rounded-md text-sm font-bold text-gray-700">
                            <option value="Aktif">Aktif</option>
                            <option value="Perawatan">Perawatan</option>
                            <option value="Rusak">Rosak</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Gambar Alat (Opsional)</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full px-4 py-2 border rounded-md text-sm bg-gray-50">
                    <span class="text-[10px] text-gray-400">Format diterima: JPG, JPEG, PNG (Maks 2MB)</span>
                </div>

                <div class="pt-4 border-t flex gap-4">
                    <button type="submit" class="p-2 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-2 rounded-md font-bold text-sm">Simpan Data</button>
                    <button type="reset" class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-8 py-2 rounded-md font-bold text-sm">Reset</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>