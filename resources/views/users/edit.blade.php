<x-app-layout>
    <x-slot name="header">
        Edit Data Pengguna
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            
            <div class="px-6 py-4 border-b border-gray-100 bg-blue-50/50 flex justify-between items-center">
                <h3 class="text-md font-bold text-blue-700 uppercase tracking-tight">Edit Pengguna: {{ $user->nama_lengkap }}</h3>
                <a href="{{ route('manajemen.users') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                    &larr; Batal & Kembali
                </a>
            </div>

            <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required 
                               class="w-full px-4 py-2 border @error('nama_lengkap') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-blue-500 text-sm">
                        @error('nama_lengkap') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">NRP / NIK</label>
                        <input type="text" name="nrp" value="{{ old('nrp', $user->nrp) }}" 
                               class="w-full px-4 py-2 border @error('nrp') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-blue-500 text-sm">
                        @error('nrp') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                               class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-blue-500 text-sm">
                        @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nomor HP / WhatsApp</label>
                        <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $user->nomor_hp) }}" 
                               class="w-full px-4 py-2 border @error('nomor_hp') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-blue-500 text-sm">
                        @error('nomor_hp') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Hak Akses (Role) <span class="text-red-500">*</span></label>
                        <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-blue-500 text-sm font-bold text-gray-700">
                            <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin (Administrator Sistem)</option>
                            <option value="Supervisor" {{ old('role', $user->role) == 'Supervisor' ? 'selected' : '' }}>Supervisor (Pengawas Lapangan)</option>
                            <option value="Operator" {{ old('role', $user->role) == 'Operator' ? 'selected' : '' }}>Operator (Input Laporan)</option>
                        </select>
                        @error('role') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jabatan Spesifik</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" 
                               class="w-full px-4 py-2 border @error('jabatan') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-blue-500 text-sm">
                        @error('jabatan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Status Karyawan <span class="text-red-500">*</span></label>
                        <select name="status_karyawan" required class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:ring-blue-500 text-sm font-bold text-gray-700">
                            <option value="Aktif" {{ old('status_karyawan', $user->status_karyawan) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Non-Aktif" {{ old('status_karyawan', $user->status_karyawan) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('status_karyawan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 border-dashed">
                    <p class="text-xs text-gray-500 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Kosongkan kolom password di bawah ini jika Anda TIDAK ingin mengubah password pengguna.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Password Baru <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="password" name="password" placeholder="Minimal 6 karakter" 
                                   class="w-full px-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md focus:ring-blue-500 text-sm">
                            @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ketik ulang password baru" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 text-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex gap-4">
                    <button type="submit" class="p-2 bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-md font-bold text-sm shadow-sm transition">
                        Update Pengguna
                    </button>
                    <a href="{{ route('manajemen.users') }}" class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-8 py-2.5 rounded-md font-bold text-sm transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>