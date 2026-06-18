<x-app-layout>
    <x-slot name="header">
        Kontrol Akses Berbasis Peran (RBAC)
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white tracking-tight transition-colors">Kontrol Akses Berbasis Peran (RBAC)</h2>
        </div>

        <div class="bg-white dark:bg-[#18181b] overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-[#27272a] transition-colors">
            
            <div class="px-6 py-4 border-b border-gray-100 dark:border-[#27272a] bg-gray-50/50 dark:bg-[#18181b] flex flex-wrap justify-between items-center gap-4 transition-colors">
                <h3 class="text-sm font-bold text-gray-700 dark:text-white transition-colors">Kontrol Akses Pengguna</h3>
                
                <form method="GET" action="{{ route('kontrol.akses') }}" class="flex items-center bg-white dark:bg-[#27272a] border border-gray-200 dark:border-[#27272a] rounded text-sm overflow-hidden shadow-sm transition-colors">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peran..." class="border-none text-sm py-1.5 px-3 focus:ring-0 w-48 bg-transparent dark:text-white dark:placeholder-gray-400 transition-colors">
                    <button type="submit" class="px-3 text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-white bg-gray-50 dark:bg-white/5 border-l border-gray-200 dark:border-[#27272a] py-1.5 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto p-6">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-[#27272a] border border-gray-100 dark:border-[#27272a] rounded-lg hidden sm:table transition-colors">
                    <thead class="bg-gray-50/80 dark:bg-white/5 transition-colors">
                        <tr class="text-xs font-bold text-gray-500 dark:text-gray-400 text-center border-b border-gray-200 dark:border-[#27272a] transition-colors">
                            <th rowspan="2" class="px-4 py-3 text-left border-r border-gray-200 dark:border-[#27272a] align-middle">Peran</th>
                            <th rowspan="2" class="px-4 py-3 border-r border-gray-200 dark:border-[#27272a] align-middle">Dashboard</th>
                            <th colspan="3" class="px-4 py-2 border-r border-gray-200 dark:border-[#27272a] border-b dark:border-b-[#27272a]">Data Laporan</th>
                            <th colspan="1" class="px-4 py-2 border-r border-gray-200 dark:border-[#27272a] border-b dark:border-b-[#27272a]">Manajemen</th>
                            <th colspan="2" class="px-4 py-2 border-r border-gray-200 dark:border-[#27272a] border-b dark:border-b-[#27272a]">Kontrol Akses</th>
                            <th rowspan="2" class="px-4 py-3 align-middle">Aksi</th>
                        </tr>
                        <tr class="text-[11px] font-bold text-gray-500 dark:text-gray-400 text-center transition-colors">
                            <th class="px-3 py-2 border-r border-gray-200 dark:border-[#27272a]">Input</th>
                            <th class="px-3 py-2 border-r border-gray-200 dark:border-[#27272a]">Verifikasi</th>
                            <th class="px-3 py-2 border-r border-gray-200 dark:border-[#27272a]">Riwayat</th>
                            <th class="px-3 py-2 border-r border-gray-200 dark:border-[#27272a]">Pengguna</th>
                            <th class="px-3 py-2 border-r border-gray-200 dark:border-[#27272a]">Lokasi</th>
                            <th class="px-3 py-2 border-r border-gray-200 dark:border-[#27272a]">Alat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-[#18181b] divide-y divide-gray-100 dark:divide-[#27272a] transition-colors">
                    @foreach($roles as $role)
                    <tr class="text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors text-center">
                        
                        <td class="px-4 py-4 text-left font-medium border-r border-gray-100 dark:border-[#27272a] transition-colors">{{ $role->name }}</td>
                        
                        @foreach($moduls as $modul)
                            <td class="px-3 py-4 border-r border-gray-100 dark:border-[#27272a] transition-colors">
                                @if($role->hasPermissionTo($modul))
                                    <svg class="w-5 h-5 text-[#3e8e63] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    <svg class="w-5 h-5 text-red-400 mx-auto opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @endif
                            </td>
                        @endforeach
                        
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('kontrol.edit', $role->name) }}" class="inline-flex bg-[#3e8e63] hover:bg-emerald-700 text-white px-5 py-1.5 rounded text-[11px] font-bold items-center shadow-sm transition">
                                ✎ Edit
                            </a>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 dark:border-[#27272a] bg-gray-50/30 dark:bg-[#18181b] flex flex-col md:flex-row justify-between items-center text-xs text-gray-500 dark:text-gray-400 font-medium gap-4 transition-colors">
                <div class="flex gap-6">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-[#3e8e63]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        Akses Diberikan
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Akses Dicegah
                    </span>
                </div>
                <div class="w-full md:w-auto mt-2 md:mt-0">
                    {{ $roles->links('pagination::tailwind') }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>