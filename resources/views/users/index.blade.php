<x-app-layout>
    <x-slot name="header">
        Manajemen Pengguna & Role
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            
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

            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white">
                <h3 class="text-md font-bold text-gray-700">Manajemen Pengguna & Role</h3>
                <a href="{{ route('users.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded text-xs font-bold shadow-sm transition">
                    + Tambah Pengguna
                </a>
            </div>

            <div class="p-6">
                <form method="GET" action="{{ route('manajemen.users') }}" id="filterForm" class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>Entries per page:</span>
                        <select name="per_page" onchange="document.getElementById('filterForm').submit()" class="border-gray-300 rounded text-sm py-1 focus:ring-emerald-500">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search..." class="border-gray-300 rounded text-sm py-1 px-3 w-64 focus:ring-emerald-500 focus:border-emerald-500">
                        <button type="submit" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 px-3 py-1 rounded text-sm transition">Cari</button>
                    </div>
                </form>

                <div class="overflow-x-auto border border-gray-100 rounded">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-bold text-gray-500 uppercase tracking-wider text-left">
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($users as $index => $user)
                            <tr class="text-sm text-gray-700 hover:bg-gray-50 transition">
                                <td class="px-6 py-4">{{ $users->firstItem() + $index }}</td>
                                <td class="px-6 py-4 font-medium">{{ $user->nama_lengkap ?? $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    {{-- Logika Warna Badge Role (Menggunakan class standar Tailwind) --}}
                                    @php
                                        $roleClass = match($user->role) {
                                            'Admin' => 'bg-emerald-500',
                                            'Supervisor' => 'bg-emerald-500',
                                            'Operator' => 'bg-emerald-500',
                                            default => 'bg-gray-500'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 text-white text-xs font-bold rounded shadow-sm {{ $roleClass }}">
                                        {{ $user->role ?? 'No Role' }}
                                    </span>
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
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic text-sm">
                                    Tidak ada data pengguna ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center text-sm text-gray-500">
                    <div>
                        Menampilkan {{ $users->firstItem() ?? 0 }} sampai {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} entri
                    </div>
                    <div class="flex items-center gap-1">
                        {{-- Prev Button --}}
                        @if ($users->onFirstPage())
                            <span class="px-3 py-1.5 border border-gray-200 rounded text-gray-300 cursor-not-allowed bg-white">Previous</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded text-gray-600 hover:bg-gray-50 bg-white transition">Previous</a>
                        @endif

                        {{-- Current Page Badge --}}
                        <span class="px-3 py-1.5 bg-emerald-600 text-white rounded font-bold shadow-sm">{{ $users->currentPage() }}</span>

                        {{-- Next Button --}}
                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded text-gray-600 hover:bg-gray-50 bg-white transition">Next</a>
                        @else
                            <span class="px-3 py-1.5 border border-gray-200 rounded text-gray-300 cursor-not-allowed bg-white">Next</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>