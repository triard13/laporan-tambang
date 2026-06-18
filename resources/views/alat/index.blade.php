<x-app-layout>
    <x-slot name="header">
        Manajemen data alat/armada
    </x-slot>

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

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-[#18181b] overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-[#27272a] transition-colors">
            
            <div class="px-6 py-4 border-b border-gray-100 dark:border-[#27272a] flex justify-between items-center bg-gray-50/50 dark:bg-[#18181b] transition-colors">
                <h3 class="text-md font-bold text-gray-700 dark:text-white transition-colors">Manajemen data alat/armada</h3>
                <a href="{{ route('alat.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded text-xs font-bold shadow-sm transition">
                    + Tambah Alat
                </a>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto border border-gray-100 dark:border-[#27272a] rounded transition-colors">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-[#27272a] transition-colors">
                        <thead class="bg-gray-50 dark:bg-white/5 transition-colors">
                            <tr class="text-xs font-bold text-gray-500 dark:text-gray-400 text-left transition-colors">
                                <th class="px-6 py-4">Gambar</th>
                                <th class="px-6 py-4">Kode Alat</th>
                                <th class="px-6 py-4">Nama Alat</th>
                                <th class="px-6 py-4 text-center">Kapasitas(BCM)</th>
                                <th class="px-6 py-4 text-center">Jam Kerja</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-[#18181b] divide-y divide-gray-100 dark:divide-[#27272a] transition-colors">
                            @forelse($alats as $alat)
                            <tr class="text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors items-center">
                                <td class="px-6 py-3">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-[#27272a] rounded border border-gray-200 dark:border-[#3f3f46] flex items-center justify-center overflow-hidden transition-colors">
                                        @if($alat->gambar)
                                            <img src="{{ asset('storage/'.$alat->gambar) }}" alt="Alat" class="w-full h-full object-contain">
                                        @else
                                            <svg class="w-6 h-6 text-gray-300 dark:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        @endif
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 font-bold text-gray-700 dark:text-white transition-colors">{{ $alat->kode_alat ?? 'N/A' }}</td>
                                
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-700 dark:text-white transition-colors">{{ $alat->nama_alat }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 transition-colors">({{ $alat->tipe_alat }})</div>
                                </td>
                                
                                <td class="px-6 py-4 text-center font-medium">{{ $alat->kapasitas ? $alat->kapasitas : '-' }}</td>
                                
                                <td class="px-6 py-4 text-center font-medium">{{ number_format($alat->jam_kerja, 0, ',', '.') }} Jam</td>
                                
                                <td class="px-6 py-4 text-center">
                                    @if($alat->status == 'Aktif')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-100 dark:border-emerald-800 rounded-md text-xs font-bold transition-colors">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            Aktif
                                        </span>
                                    @elseif($alat->status == 'Perawatan')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/30 border border-amber-100 dark:border-amber-800 rounded-md text-xs font-bold transition-colors">
                                            <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                                            Perawatan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/30 border border-red-100 dark:border-red-800 rounded-md text-xs font-bold transition-colors">
                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                            Rusak
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('alat.edit', $alat->id) }}" class="bg-[#3e8e63] hover:bg-emerald-700 text-white w-8 h-8 rounded text-[11px] font-bold flex flex-row items-center justify-center gap-1 shadow-sm transition whitespace-nowrap">
                                            ✎
                                        </a>
                                        <form action="{{ route('alat.destroy', $alat->id) }}" method="POST" class="m-0 p-0 flex" onsubmit="return confirm('Yakin ingin menghapus alat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400 hover:bg-red-500 hover:text-white dark:hover:bg-red-600 dark:hover:text-white border border-red-100 dark:border-red-800 w-8 h-8 rounded text-[11px] font-bold transition-all flex items-center justify-center shadow-sm">
                                                🗑
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500 italic text-sm transition-colors">
                                    Data alat belum tersedia.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400 transition-colors">
                    <div>
                        Menampilkan {{ $alats->firstItem() ?? 0 }} sampai {{ $alats->lastItem() ?? 0 }} dari {{ $alats->total() }} entri
                    </div>
                    <div>
                        {{ $alats->links('pagination::tailwind') }} </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>