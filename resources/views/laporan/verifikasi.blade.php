<x-app-layout>
    <x-slot name="header">
        Verifikasi Laporan Harian
    </x-slot>

    <div class="bg-white dark:bg-[#18181b] overflow-hidden shadow-sm sm:rounded-lg transition-colors">
        <div class="p-6 bg-white dark:bg-[#18181b] border-b border-gray-200 dark:border-[#27272a] transition-colors">
            
            @if(session('success'))
                <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4 transition-colors">Daftar Laporan Menunggu Verifikasi</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-[#27272a] transition-colors">
                    <thead class="bg-gray-50 dark:bg-white/5 transition-colors">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors">Shift</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors">Alat Berat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors">Operator</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors">Produksi [BCM]</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase transition-colors">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-[#18181b] divide-y divide-gray-200 dark:divide-[#27272a] transition-colors">
                        @forelse ($laporans as $laporan)
                            <tr x-data="{ openModal: false }" class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 transition-colors">
                                    {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 transition-colors">
                                    Shift 1
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 transition-colors">
                                    {{ $laporan->lokasi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 transition-colors">
                                    {{ $laporan->alatTambang->nama_alat ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300 transition-colors">
                                    {{ $laporan->user->nama_lengkap ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-900 dark:text-gray-100 transition-colors">
                                    {{ number_format($laporan->volume, 0, ',', '.') }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex justify-center gap-2 items-center">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded">
                                            Menunggu Verifikasi
                                        </span>
                                        <button type="button" @click="openModal = true" class="bg-[#2b2b36] hover:bg-gray-800 text-white text-xs font-semibold py-1 px-4 rounded shadow">
                                            ✎ Verifikasi
                                        </button>
                                    </div>

                                    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none; text-align: left;">
                                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                            
                                            <div x-show="openModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="openModal = false"></div>

                                            <div x-show="openModal" 
                                                 x-transition:enter="ease-out duration-300" 
                                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                                 x-transition:leave="ease-in duration-200" 
                                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                                 class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#18181b] shadow-xl rounded-lg relative z-50">
                                                
                                                <div class="flex items-center justify-between mb-5">
                                                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Verifikasi Laporan Harian</h3>
                                                    <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>

                                                <div class="mt-2 space-y-4 text-sm text-gray-700 dark:text-gray-300 whitespace-normal">
                                                    <div class="grid grid-cols-3 gap-2">
                                                        <div class="font-medium text-gray-500 dark:text-gray-400">Tanggal:</div>
                                                        <div class="col-span-2">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</div>
                                                        
                                                        <div class="font-medium text-gray-500 dark:text-gray-400">Shift:</div>
                                                        <div class="col-span-2 font-semibold">Shift 1</div>
                                                        
                                                        <div class="font-medium text-gray-500 dark:text-gray-400">Lokasi Tambang:</div>
                                                        <div class="col-span-2">{{ $laporan->lokasi }}</div>
                                                        
                                                        <div class="font-medium text-gray-500 dark:text-gray-400 flex items-center">Alat Berat:</div>
                                                        <div class="col-span-2 flex items-center gap-2">
                                                            <span>{{ $laporan->alatTambang->nama_alat ?? '-' }}</span>
                                                        </div>

                                                        <div class="font-medium text-gray-500 dark:text-gray-400">Operator:</div>
                                                        <div class="col-span-2">{{ $laporan->user->nama_lengkap ?? '-' }}</div>
                                                    </div>

                                                    <div class="p-4 mt-4 bg-gray-50 dark:bg-white/5 rounded-lg border border-gray-100 dark:border-transparent grid grid-cols-2 gap-y-4">
                                                        <div>
                                                            <span class="block text-gray-500 dark:text-gray-400 text-xs">Produksi [BCM]</span>
                                                            <span class="font-bold text-gray-900 dark:text-white text-lg">{{ number_format($laporan->volume, 0, ',', '.') }}</span>
                                                        </div>
                                                        <div>
                                                            <span class="block text-gray-500 dark:text-gray-400 text-xs">Jam Kerja</span>
                                                            <span class="font-medium text-gray-900 dark:text-gray-200">{{ $laporan->jam_operasi }} jam</span>
                                                        </div>
                                                        <div>
                                                            <span class="block text-gray-500 dark:text-gray-400 text-xs">Konsumsi BBM</span>
                                                            <span class="font-medium text-gray-900 dark:text-gray-200">{{ $laporan->bahan_bakar }} liter</span>
                                                        </div>
                                                        <div>
                                                            <span class="block text-gray-500 dark:text-gray-400 text-xs">Kendala</span>
                                                            <span class="font-medium text-gray-900 dark:text-gray-200">
                                                                @if($laporan->hambatans && $laporan->hambatans->count() > 0)
                                                                    {{ $laporan->hambatans->first()->jenis_hambatan }}
                                                                @else
                                                                    Tidak Ada
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <form action="{{ route('laporan.process_verifikasi', $laporan->id) }}" method="POST" class="mt-6">
                                                    @csrf
                                                    <div class="mb-4">
                                                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Catatan Verifikasi (Opsional)</label>
                                                        <textarea name="catatan" rows="2" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-[#27272a] rounded-md bg-gray-50 dark:bg-[#27272a] dark:text-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition-colors" placeholder="Ketik catatan di sini..."></textarea>
                                                    </div>

                                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-[#27272a]">
                                                        <button type="submit" name="status_validasi" value="Ditolak" class="px-5 py-2 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-md flex items-center gap-1 transition focus:outline-none">
                                                            <span>✕</span> Tolak
                                                        </button>
                                                        <button type="submit" name="status_validasi" value="Disetujui" class="px-5 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-md flex items-center gap-1 transition shadow focus:outline-none">
                                                            <span>✓</span> Setujui
                                                        </button>
                                                    </div>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada laporan yang menunggu verifikasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>