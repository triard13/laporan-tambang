<x-app-layout>
    <x-slot name="header">
        Manajemen Pengguna & Role
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-[#18181b] overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-[#27272a] transition-colors">
            
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

            <div class="px-6 py-4 border-b border-gray-100 dark:border-[#27272a] flex justify-between items-center bg-white dark:bg-[#18181b] transition-colors">
                <h3 class="text-md font-bold text-gray-700 dark:text-white transition-colors">Manajemen Pengguna & Role</h3>
                <a href="{{ route('users.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded text-xs font-bold shadow-sm transition">
                    + Tambah Pengguna
                </a>
            </div>

            <div class="p-6">
                <form method="GET" action="{{ route('manajemen.users') }}" id="filterForm" class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300 transition-colors">
                        <span>Entries per page:</span>
                        <select name="per_page" onchange="document.getElementById('filterForm').submit()" class="border-gray-300 dark:border-[#27272a] bg-white dark:bg-[#27272a] dark:text-white rounded text-sm py-1 focus:ring-emerald-500 transition-colors">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search..." class="border-gray-300 dark:border-[#27272a] bg-white dark:bg-[#27272a] dark:text-white rounded text-sm py-1 px-3 w-64 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        <button type="submit" class="bg-gray-100 dark:bg-white/5 hover:bg-gray-200 dark:hover:bg-white/10 border border-gray-300 dark:border-[#27272a] text-gray-700 dark:text-gray-300 px-3 py-1 rounded text-sm transition-colors">Cari</button>
                    </div>
                </form>

                <div class="overflow-x-auto border border-gray-100 dark:border-[#27272a] rounded transition-colors">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-[#27272a] transition-colors">
                        <thead class="bg-gray-50 dark:bg-white/5 transition-colors">
                            <tr class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-left transition-colors">
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Nama & NRP</th>
                                <th class="px-6 py-4">Kontak</th>
                                <th class="px-6 py-4">Role & Jabatan</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-[#18181b] divide-y divide-gray-100 dark:divide-[#27272a] transition-colors">
                            @forelse($users as $index => $user)
                            <tr class="text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">{{ $users->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800 dark:text-white transition-colors">{{ $user->nama_lengkap ?? $user->name }}</div>
                                    @if($user->nrp)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 transition-colors">NRP: {{ $user->nrp }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-700 dark:text-gray-300 transition-colors">{{ $user->email }}</div>
                                    @if($user->nomor_hp)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $user->nomor_hp }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-emerald-800 bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 text-[10px] font-bold rounded shadow-sm transition-colors">
                                        {{ $user->role ?? 'No Role' }}
                                    </span>
                                    @if($user->jabatan)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 transition-colors">{{ $user->jabatan }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->status_karyawan == 'Aktif' || !$user->status_karyawan)
                                        <span class="px-2 py-1 text-green-700 bg-green-100 border border-green-200 dark:bg-green-900/30 dark:border-green-800 dark:text-green-400 text-xs rounded-full transition-colors">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 text-red-700 bg-red-100 border border-red-200 dark:bg-red-900/30 dark:border-red-800 dark:text-red-400 text-xs rounded-full transition-colors">Non-Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs flex items-center gap-1 transition shadow-sm font-bold">
                                            ✎ Edit
                                        </a>
                                        
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs flex items-center gap-1 transition shadow-sm font-bold">
                                                🗑 Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500 italic text-sm transition-colors">
                                    Tidak ada data pengguna ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400 transition-colors">
                    <div>
                        Menampilkan {{ $users->firstItem() ?? 0 }} sampai {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} entri
                    </div>
                    <div class="flex items-center gap-1">
                        {{-- Prev Button --}}
                        @if ($users->onFirstPage())
                            <span class="px-3 py-1.5 border border-gray-200 dark:border-[#27272a] rounded text-gray-300 dark:text-gray-600 cursor-not-allowed bg-white dark:bg-[#27272a] transition-colors">Previous</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1.5 border border-gray-200 dark:border-[#27272a] rounded text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 bg-white dark:bg-[#27272a] transition-colors">Previous</a>
                        @endif

                        {{-- Current Page Badge --}}
                        <span class="px-3 py-1.5 bg-emerald-600 text-white rounded font-bold shadow-sm transition-colors">{{ $users->currentPage() }}</span>

                        {{-- Next Button --}}
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1.5 border border-gray-200 dark:border-[#27272a] rounded text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 bg-white dark:bg-[#27272a] transition-colors">Next</a>
                        @else
                            <span class="px-3 py-1.5 border border-gray-200 dark:border-[#27272a] rounded text-gray-300 dark:text-gray-600 cursor-not-allowed bg-white dark:bg-[#27272a] transition-colors">Next</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>