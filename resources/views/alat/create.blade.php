<x-app-layout>
    <x-slot name="header">Tambah Alat Berat Baru</x-slot>

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