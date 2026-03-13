<x-app-layout>
    <x-slot name="header">
        Audit Log / Jejak Perubahan
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800 tracking-tight mb-2">Audit Log / Jejak Perubahan</h2>
            <p class="text-sm text-gray-500 leading-relaxed max-w-4xl">
                Menampilkan seluruh jejak perubahan dan aktivitas yang dilakukan. Anda dapat memantau log aktivitas seluruh pengguna di dalam sistem.
            </p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            
            <form method="GET" action="{{ route('log.aktifitas') }}" class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-wrap gap-4 items-center justify-between">
                <div class="flex items-center gap-4 flex-1 flex-wrap">
                    
                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded text-sm overflow-hidden shadow-sm">
                        <span class="pl-3 py-1.5 text-gray-500 font-bold bg-gray-50 border-r border-gray-200">Aksi</span>
                        <select name="aksi" onchange="this.form.submit()" class="border-none text-gray-600 text-sm py-1.5 focus:ring-0 pr-8 bg-transparent cursor-pointer">
                            <option value="Semua Aksi">Semua Aksi</option>
                            <option value="Menambah" {{ request('aksi') == 'Menambah' ? 'selected' : '' }}>Menambah</option>
                            <option value="Mengedit" {{ request('aksi') == 'Mengedit' ? 'selected' : '' }}>Mengedit</option>
                            <option value="Menghapus" {{ request('aksi') == 'Menghapus' ? 'selected' : '' }}>Menghapus</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2 bg-white border border-gray-200 rounded text-sm overflow-hidden shadow-sm">
                        <span class="pl-3 py-1.5 text-gray-500 font-bold bg-gray-50 border-r border-gray-200">Pengguna</span>
                        <select name="user_id" onchange="this.form.submit()" class="border-none text-gray-600 text-sm py-1.5 focus:ring-0 pr-8 bg-transparent cursor-pointer">
                            <option value="Semua Pengguna">Semua Pengguna</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center bg-white border border-gray-200 rounded text-sm overflow-hidden shadow-sm px-2">
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="border-none text-sm text-gray-600 py-1.5 focus:ring-0 bg-transparent">
                        <span class="text-gray-400 px-1">-</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="border-none text-sm text-gray-600 py-1.5 focus:ring-0 bg-transparent">
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button type="submit" class="p-2 border border-gray-200 rounded text-gray-500 hover:text-white hover:bg-emerald-600 bg-white shadow-sm transition" title="Terapkan Filter">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </button>
                    @if(request()->hasAny(['aksi', 'user_id', 'start_date']))
                        <a href="{{ route('log.aktifitas') }}" class="p-2 border border-red-200 rounded text-red-500 hover:text-white hover:bg-red-500 bg-red-50 shadow-sm transition" title="Reset Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-white">
                        <tr class="text-xs font-bold text-gray-500 text-left border-b border-gray-200">
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Aksi</th>
                            <th class="px-6 py-4">Modul</th>
                            <th class="px-6 py-4">Detil Perubahan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @forelse($logs as $log)
                        <tr class="text-[13px] text-gray-600 hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-700">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-[11px] text-gray-400">{{ $log->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="{{ isset($log->user) && $log->user->foto_profil ? asset('storage/' . $log->user->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($log->user->nama_lengkap ?? 'Sistem') . '&background=random&color=fff' }}" 
                                    class="w-8 h-8 rounded-full border border-gray-200 shadow-sm object-cover" 
                                    alt="Avatar">
                                
                                <div>
                                    <div class="font-bold text-gray-800">{{ $log->user->nama_lengkap ?? 'Pengguna Dihapus' }}</div>
                                    <div class="text-[11px] text-gray-500">
                                        {{ isset($log->user) ? ($log->user->getRoleNames()->first() ?? $log->user->role) : '-' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{-- Logika Warna Badge Aksi Dinamis --}}
                                @php
                                    $bgBadge = match($log->aksi) {
                                        'Menambah' => 'bg-emerald-500',
                                        'Mengedit' => 'bg-[#315787]',
                                        'Menghapus' => 'bg-red-500',
                                        'Verifikasi Disetujui' => 'bg-[#44b887]',
                                        'Verifikasi Dibatalkan' => 'bg-red-500',
                                        default => 'bg-gray-500'
                                    };
                                @endphp
                                <span class="px-3 py-1 text-white text-[11px] font-bold rounded shadow-sm {{ $bgBadge }}">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-700">{{ $log->modul }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 leading-relaxed">
                                {!! nl2br(e($log->detail)) !!}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic text-sm">
                                Belum ada jejak aktivitas yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500 bg-white">
                <div class="px-6 py-4 border-t border-gray-100 bg-white">
                    {{ $logs->links('pagination::tailwind') }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>