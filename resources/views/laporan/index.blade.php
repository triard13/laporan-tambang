<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Laporan Produksi Tambang</h2>
            <a href="{{ route('laporan.export', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Ekspor Excel
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900">
            <form action="{{ route('laporan.riwayat') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="w-full md:w-1/4">
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Mulai Tanggal</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                </div>
                <div class="w-full md:w-1/4">
                    <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                </div>
                <div class="w-full md:w-1/4">
                    <label for="status_laporan" class="block text-sm font-medium text-gray-700">Status Laporan</label>
                    <select name="status_laporan" id="status_laporan" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Semua Status</option>
                        <option value="Disetujui" {{ request('status_laporan') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Pending" {{ request('status_laporan') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Ditolak" {{ request('status_laporan') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="Revisi" {{ request('status_laporan') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Filter
                    </button>
                    @if(request()->anyFilled(['tanggal_mulai', 'tanggal_akhir', 'status_laporan']))
                        <a href="{{ route('laporan.riwayat') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            
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

            <div class="mb-6 bg-amber-50 border-l-4 border-amber-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-amber-700">
                            Berikut adalah daftar seluruh laporan produksi tambang. Anda dapat melihat status laporan apakah sudah disetujui, ditolak, atau menunggu verifikasi.
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shift</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat Berat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operator</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produksi [BCM]</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($laporans as $laporan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}
                                </td>
                               <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $laporan->shift }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $laporan->lokasiTambang->nama_lokasi ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="font-medium text-gray-900">{{ $laporan->alatTambang->nama_alat ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">({{ $laporan->alatTambang->tipe_alat ?? '-' }})</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $laporan->user->nama_lengkap ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                    {{ number_format($laporan->volume, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($laporan->status_laporan == 'Disetujui')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            ✔ Disetujui
                                        </span>
                                    @elseif($laporan->status_laporan == 'Ditolak' || $laporan->status_laporan == 'Revisi')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            ✖ {{ $laporan->status_laporan }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            ⏳ Menunggu
                                        </span>
                                    @endif
                                                                        @if($laporan->status_laporan == 'Pending')
                                        <a href="{{ route('laporan.edit', $laporan->id) }}" class="inline-flex items-center px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-bold rounded shadow-sm transition">
                                            ✎ Detail
                                        </a>
                                    @else
                                        <span class="text-[9px] text-gray-400 italic">Locked</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                    Belum ada data laporan harian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $laporans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>