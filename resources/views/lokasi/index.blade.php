<x-app-layout>
    <x-slot name="header">
        Manajemen Lokasi Tambang
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-white">
                <h3 class="text-lg font-normal text-gray-800 tracking-tight">Manajemen Lokasi Tambang</h3>
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

                <div class="overflow-x-auto border border-gray-100 rounded">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr class="text-xs font-medium text-gray-500 text-left">
                                <th class="px-4 py-3 w-10 text-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </th>
                                <th class="px-6 py-3">Lokasi</th>
                                <th class="px-6 py-3">Koordinat (Titik Tengah)</th>
                                <th class="px-6 py-3">Luas Area</th>
                                <th class="px-6 py-3">Koordinator</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($lokasis as $lokasi)
                            <tr class="text-sm text-gray-600 hover:bg-gray-50 transition">
                                <td class="px-4 py-4 text-center">
                                    <input type="checkbox" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                </td>
                                <td class="px-6 py-4">{{ $lokasi->nama_lokasi }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-700">{{ $lokasi->koordinat ?? '-' }}</div>
                                    <div class="text-xs text-gray-400">({{ $lokasi->koordinat ?? '-' }})</div>
                                </td>
                                <td class="px-6 py-4">{{ $lokasi->luas_area ?? 0 }} Hektar</td>
                                <td class="px-6 py-4">{{ $lokasi->koordinator ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('lokasi.edit', $lokasi->id) }}" class="bg-[#3e8e63] hover:bg-emerald-700 text-white px-3 py-1.5 rounded text-[11px] font-bold flex items-center gap-1 shadow-sm transition">
                                            ✎ Edit
                                        </a>
                                        <form action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-white text-red-500 hover:bg-red-50 border border-red-200 px-3 py-1.5 rounded text-[11px] font-bold transition flex items-center justify-center">
                                                🗑
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic text-sm">
                                    Belum ada data lokasi tambang.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center text-sm text-gray-500">
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