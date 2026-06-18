<x-app-layout>
    <x-slot name="header">
        Manajemen Lokasi Tambang
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-[#18181b] overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-[#27272a] transition-colors">
            
            <div class="px-6 py-4 border-b border-gray-100 dark:border-[#27272a] flex justify-between items-center bg-white dark:bg-[#18181b] transition-colors">
                <h3 class="text-lg font-normal text-gray-800 dark:text-white tracking-tight transition-colors">Manajemen Lokasi Tambang</h3>
                <a href="{{ route('lokasi.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded text-xs font-bold shadow-sm transition">
                    + Tambah Lokasi
                </a>
            </div>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 flex items-center p-4 text-emerald-800 border-l-4 border-emerald-500 bg-emerald-50 rounded-r-lg">
                        <span class="text-sm font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto border border-gray-100 dark:border-[#27272a] rounded transition-colors">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-[#27272a] transition-colors">
                        <thead class="bg-gray-50/50 dark:bg-white/5 transition-colors">
                            <tr class="text-xs font-medium text-gray-500 dark:text-gray-400 text-left transition-colors">
                                <th class="px-4 py-3 w-10 text-center">
                                    <input type="checkbox" class="rounded border-gray-300 dark:border-[#27272a] bg-white dark:bg-[#27272a] text-emerald-600 focus:ring-emerald-500 transition-colors">
                                </th>
                                <th class="px-6 py-3">Lokasi</th>
                                <th class="px-6 py-3">Koordinat (Titik Tengah)</th>
                                <th class="px-6 py-3">Luas Area</th>
                                <th class="px-6 py-3">Koordinator</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-[#18181b] divide-y divide-gray-100 dark:divide-[#27272a] transition-colors">
                            @forelse($lokasis as $lokasi)
                            <tr class="text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" class="rounded border-gray-300 dark:border-[#27272a] bg-white dark:bg-[#27272a] text-emerald-600 focus:ring-emerald-500 transition-colors">
                                </td>
                                <td class="px-6 py-4">{{ $lokasi->nama_lokasi }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-700 dark:text-gray-300 transition-colors">{{ $lokasi->koordinat ?? '-' }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 transition-colors">({{ $lokasi->koordinat ?? '-' }})</div>
                                </td>
                                <td class="px-6 py-4">{{ $lokasi->luas_area ?? 0 }} Hektar</td>
                                <td class="px-6 py-4">{{ $lokasi->koordinator ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('lokasi.edit', $lokasi->id) }}" class="bg-[#3e8e63] hover:bg-emerald-700 text-white px-3 py-1.5 rounded text-[11px] font-bold flex flex-row items-center justify-center gap-1 shadow-sm transition whitespace-nowrap h-8">
                                            ✎ Edit
                                        </a>
                                        <form action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST" class="m-0 p-0 flex" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-white dark:bg-[#27272a] text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 border border-red-200 dark:border-red-800 w-8 h-8 rounded text-[11px] font-bold transition flex items-center justify-center shadow-sm">
                                                🗑
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500 italic text-sm transition-colors">
                                    Belum ada data lokasi tambang.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400 transition-colors">
                    <div>
                        Menampilkan {{ $lokasis->firstItem() ?? 0 }} sampai {{ $lokasis->lastItem() ?? 0 }} dari {{ $lokasis->total() }} entri
                    </div>
                    <div>
                        {{ $lokasis->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>