<x-app-layout>
    <x-slot name="header">
        Tambah Pengguna Baru
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-md font-bold text-gray-700 uppercase tracking-tight">Form Tambah Pengguna</h3>
                <a href="{{ route('manajemen.users') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                    &larr; Kembali
                </a>
            </div>

            <form action="{{ route('users.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Misal: Agus Wijaya" 
                               class="w-full px-4 py-2 border @error('nama_lengkap') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-emerald-500 text-sm">
                        @error('nama_lengkap') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Misal: agus@tambang.com" 
                               class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-emerald-500 text-sm">
                        @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter" 
                               class="w-full px-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-emerald-500 text-sm">
                        @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Pilih Role / Hak Akses <span class="text-red-500">*</span></label>
                        <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-emerald-500 text-sm font-bold text-gray-700">
                            <option value="">-- Pilih Role --</option>
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin (Administrator Sistem)</option>
                            <option value="Supervisor" {{ old('role') == 'Supervisor' ? 'selected' : '' }}>Supervisor (Pengawas Lapangan)</option>
                            <option value="Operator" {{ old('role') == 'Operator' ? 'selected' : '' }}>Operator (Input Laporan)</option>
                        </select>
                        @error('role') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required placeholder="Ketik ulang password" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-emerald-500 text-sm">
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex gap-4">
                    <button type="submit" class="p-2 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-2.5 rounded-md font-bold text-sm shadow-sm transition">
                        Simpan Pengguna
                    </button>
                    <button type="reset" class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-8 py-2.5 rounded-md font-bold text-sm transition">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>