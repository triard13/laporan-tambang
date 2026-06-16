<x-app-layout>
    <x-slot name="header">Dashboard KPI & Visualisasi Data</x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-6 pb-10">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border flex justify-between items-center border-l-4 border-l-emerald-500">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Total Produksi (BCM)</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ number_format($totalProduksi, 0, ',', '.') }}</h3>
                    <p class="text-xs mt-1 font-bold {{ $growthProduksi >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $growthProduksi >= 0 ? '▲' : '▼' }} {{ number_format(abs($growthProduksi), 1) }}% 
                        <span class="text-gray-400 font-normal">dibandingkan minggu lalu</span>
                    </p>
                </div>
                <div class="bg-emerald-50 p-3 rounded-full text-emerald-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border flex justify-between items-center border-l-4 border-l-blue-500">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Laporan Disetujui</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $laporanDisetujui }}</h3>
                    <p class="text-xs mt-1 font-bold {{ $growthLaporan >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $growthLaporan >= 0 ? '▲' : '▼' }} {{ number_format(abs($growthLaporan), 1) }}% 
                        <span class="text-gray-400 font-normal">dibandingkan minggu lalu</span>
                    </p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border flex justify-between items-center border-l-4 border-l-amber-500">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Laporan Ditolak / Menunggu</p>
                    <h3 class="text-3xl font-bold text-gray-800"><span class="text-red-500">{{ $laporanDitolak }}</span> / <span class="text-amber-500">{{ $laporanPending }}</span></h3>
                    <p class="text-xs text-amber-500 mt-1 font-bold">▲ {{ number_format($percPending, 1) }}% <span class="text-gray-400 font-normal">laporan pending</span></p>
                </div>
                <div class="bg-amber-50 p-3 rounded-full text-red-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-bold text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Grafik Produksi Harian
                    </h4>
                    
                    <form action="{{ route('dashboard') }}" method="GET" id="filterForm">
                        <select name="range" onchange="this.form.submit()" class="text-xs border-gray-300 rounded shadow-sm focus:ring-emerald-500 py-1">
                            <option value="7" {{ $range == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                            <option value="14" {{ $range == 14 ? 'selected' : '' }}>14 Hari Terakhir</option>
                            <option value="30" {{ $range == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                        </select>
                    </form>
                </div>
                <div class="mb-4">
                    <p class="text-xs text-gray-500">{{ now()->format('d M Y') }}</p>
                    <p class="text-sm font-medium text-gray-700">
                        Total Produksi: <span class="font-bold">{{ number_format($totalProduksiHariIni, 0, ',', '.') }} BCM</span></p>
                </div>
                <div class="relative h-64 w-full">
                    <canvas id="prodChart"></canvas>
                    @if(count($chartData) == 0)
                        <div class="absolute inset-0 flex items-center justify-center bg-gray-50 bg-opacity-50 text-gray-400 text-sm italic">
                            Belum ada data pada periode ini.
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex flex-col h-full">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-bold text-gray-700">Distribusi Lokasi Produksi</h4>
                    <div class="text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </div>
                </div>
                
                <div class="relative h-64 w-full mb-6">
                    <canvas id="locChart"></canvas>
                </div>

                <div class="grid grid-cols-2 gap-4 border-t border-gray-50 pt-4">
                    @foreach($lokasiData as $index => $ld)
                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-3 h-3 rounded-sm {{ $index == 0 ? 'bg-[#2D5A43]' : ($index == 1 ? 'bg-[#66D391]' : 'bg-emerald-100') }}"></span>
                            <span class="text-[11px] font-bold text-gray-700 uppercase tracking-tight">{{ $ld->lokasiTambang->nama_lokasi ?? 'N/A' }}</span>
                        </div>
                        <div class="pl-5">
                            <span class="text-xs font-bold text-gray-900 block">{{ number_format($ld->total, 0, ',', '.') }}</span>
                            <span class="text-[10px] text-gray-400 font-medium italic">BCM</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">TARGET vs REALISASI PRODUKSI BATU BOULDER PT. BGA</h3>
                
                <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-2">
                    <label class="font-medium text-gray-700">Filter:</label>
                    
                    <select name="bulan" class="border border-gray-300 rounded-md p-2" onchange="this.form.submit()">
                        <option value="01" {{ $bulan == '01' ? 'selected' : '' }}>Januari</option>
                        <option value="02" {{ $bulan == '02' ? 'selected' : '' }}>Februari</option>
                        <option value="03" {{ $bulan == '03' ? 'selected' : '' }}>Maret</option>
                        <option value="04" {{ $bulan == '04' ? 'selected' : '' }}>April</option>
                        <option value="05" {{ $bulan == '05' ? 'selected' : '' }}>Mei</option>
                        <option value="06" {{ $bulan == '06' ? 'selected' : '' }}>Juni</option>
                        <option value="07" {{ $bulan == '07' ? 'selected' : '' }}>Juli</option>
                        <option value="08" {{ $bulan == '08' ? 'selected' : '' }}>Agustus</option>
                        <option value="09" {{ $bulan == '09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ $bulan == '10' ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ $bulan == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ $bulan == '12' ? 'selected' : '' }}>Desember</option>
                    </select>

                    <select name="tahun" class="border border-gray-300 rounded-md p-2" onchange="this.form.submit()">
                        @foreach($tahunTersedia as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div style="position: relative; height:400px; width:100%">
                <canvas id="produksiChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100 flex flex-col h-full">
                <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-[12px] font-bold text-gray-700 uppercase tracking-tight">Grafik Produksi Harian</h3>
                    <span class="text-[12px] bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded-full font-bold uppercase tracking-tighter">Hari Ini</span>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr class="text-[12px] font-bold text-gray-400 uppercase tracking-widest text-left">
                                <th class="px-4 py-3 whitespace-nowrap">Tanggal</th>
                                <th class="px-4 py-3">Shift</th>
                                <th class="px-4 py-3">Lokasi</th>
                                <th class="px-4 py-3">Alat Berat</th>
                                <th class="px-4 py-3 text-right">Produksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @forelse($laporanProduksi as $lp)
                            <tr class="text-[12px] text-gray-600 hover:bg-gray-50/80 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap font-bold text-gray-700">
                                    {{ \Carbon\Carbon::parse($lp->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">Shift 1</td>
                                <td class="px-4 py-4 whitespace-nowrap font-medium">{{ $lp->lokasiTambang->nama_lokasi ?? '-' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="font-bold text-gray-800 leading-tight">{{ $lp->alatTambang->nama_alat ?? 'Exca-01' }}</div>
                                    <div class="text-[8px] text-gray-400 font-normal italic">({{ $lp->alatTambang->tipe_alat ?? 'Excavator' }})</div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap font-bold text-right text-sm text-gray-900">
                                    {{ number_format($lp->volume, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-gray-400 italic text-[10px]">
                                    Data untuk hari ini belum tersedia.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-auto px-5 py-3 bg-white border-t border-gray-50 flex justify-between items-center">
                    <p class="text-[9px] text-gray-400 font-medium">
                        Tampil {{ $laporanProduksi->firstItem() ?? 0 }}-{{ $laporanProduksi->lastItem() ?? 0 }} dari {{ $laporanProduksi->total() }}
                    </p>
                    <div class="flex items-center gap-1">
                        @if ($laporanProduksi->onFirstPage())
                            <span class="px-2 py-1 border border-gray-100 rounded text-gray-200 text-[9px] cursor-not-allowed">Prev</span>
                        @else
                            <a href="{{ $laporanProduksi->previousPageUrl() }}" class="px-2 py-1 border border-gray-200 rounded text-gray-500 text-[9px] hover:bg-gray-50">Prev</a>
                        @endif

                        <span class="px-2 py-1 bg-[#5a8d6e] text-white rounded-sm font-bold text-[9px]">{{ $laporanProduksi->currentPage() }}</span>

                        @if ($laporanProduksi->hasMorePages())
                            <a href="{{ $laporanProduksi->nextPageUrl() }}" class="px-2 py-1 border border-gray-200 rounded text-gray-500 text-[9px] hover:bg-gray-50">Next</a>
                        @else
                            <span class="px-2 py-1 border border-gray-100 rounded text-gray-200 text-[9px] cursor-not-allowed">Next</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 flex flex-col h-full">
                <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-[12px] font-bold text-gray-700 uppercase tracking-tight">Laporan Terakhir</h3>
                    <div class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </div>
                </div>
                
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-50">
                        <thead class="bg-gray-50/50">
                            <tr class="text-[9px] font-bold text-gray-400 uppercase tracking-widest text-left">
                                <th class="px-3 py-3">Tanggal</th>
                                <th class="px-2 py-3">Lokasi</th>
                                <th class="px-2 py-3 text-center">Status Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @foreach($laporanTerakhir as $lt)
                            <tr class="text-[10px] text-gray-600 hover:bg-gray-50/80 transition-colors">
                                <td class="px-3 py-1 whitespace-nowrap">
                                    <div class="font-bold text-gray-700 leading-tight">{{ \Carbon\Carbon::parse($lt->tanggal)->format('d M Y') }}</div>
                                    <div class="text-[8px] text-gray-400 font-normal uppercase tracking-tighter">Shift 1</div>
                                </td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <div class="font-bold text-gray-800 leading-tight uppercase">{{ $lt->lokasiTambang->nama_lokasi ?? '-' }}</div>
                                    <div class="text-[8px] text-gray-400 font-medium tracking-tight truncate">{{ $lt->alatTambang->nama_alat ?? 'N/A' }}</div>
                                </td>
                                <td class="px-2 py-1 whitespace-nowrap">
                                    <div class="flex-1 py-4 flex flex-col items-center justify-center gap-1.5">
    
                                        @if($lt->status_laporan == 'Disetujui')
                                            <div class="w-[85px] flex items-center justify-center gap-1 px-2 py-1 bg-emerald-50 text-[#3e8e63] border border-emerald-100 rounded-sm font-bold text-[8px] uppercase tracking-tighter">
                                                <span class="w-2 h-2 bg-[#3e8e63] text-white rounded-full flex items-center justify-center text-[6px]">✔</span> DISETUJUI
                                            </div>
                                        @elseif($lt->status_laporan == 'Ditolak')
                                            <div class="w-[85px] flex items-center justify-center gap-1 px-2 py-1 bg-red-50 text-red-600 border border-red-100 rounded-sm font-bold text-[8px] uppercase tracking-tighter">
                                                <span class="text-[8px]">✖</span> DITOLAK
                                            </div>
                                        @else
                                            <div class="w-[85px] flex items-center justify-center gap-1 px-2 py-1 bg-amber-50 text-amber-600 border border-amber-100 rounded-sm font-bold text-[8px] uppercase tracking-tighter">
                                                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span> MENUNGGU
                                            </div>
                                        @endif

                                        @if($lt->status_laporan != 'Disetujui')
                                            <a href="{{ route('laporan.edit', $lt->id) }}" class="w-[85px] inline-flex justify-center items-center px-2 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-[9px] font-bold rounded-sm shadow-sm transition">
                                                Detail
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-auto px-5 py-3 bg-white border-t border-gray-50 flex justify-center items-center">
                    <div class="flex items-center gap-2">
                        @if ($laporanTerakhir->onFirstPage())
                            <span class="p-1 border border-gray-100 rounded text-gray-200 cursor-not-allowed">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </span>
                        @else
                            <a href="{{ $laporanTerakhir->previousPageUrl() }}" class="p-1 border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </a>
                        @endif

                        <span class="text-[10px] font-bold text-gray-400 mx-1">{{ $laporanTerakhir->currentPage() }}</span>

                        @if ($laporanTerakhir->hasMorePages())
                            <a href="{{ $laporanTerakhir->nextPageUrl() }}" class="p-1 border border-gray-200 rounded text-gray-500 hover:bg-gray-50">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <span class="p-1 border border-gray-100 rounded text-gray-200 cursor-not-allowed">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        @endif
                        
                        <a href="{{ $laporanTerakhir->nextPageUrl() }}" class="text-[9px] font-bold text-gray-700 ml-1 uppercase tracking-tighter {{ !$laporanTerakhir->hasMorePages() ? 'opacity-30 cursor-not-allowed' : 'hover:underline' }}">Next</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Agar scrollbar lebih tipis dan cantik (untuk Chrome/Safari) */
        .custom-scrollbar::-webkit-scrollbar {
            height: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // --- 1. Line Chart (Produksi Harian) ---
            const canvasProd = document.getElementById('prodChart');
            const dataLabels = {!! json_encode($chartData->pluck('date')) !!};
            const dataValues = {!! json_encode($chartData->pluck('total')) !!};

            if (canvasProd && dataLabels.length > 0) {
                const prodCtx = canvasProd.getContext('2d');
                new Chart(prodCtx, {
                    type: 'line',
                    data: {
                        labels: dataLabels,
                        datasets: [{
                            label: 'Produksi (BCM)',
                            data: dataValues,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#10b981'
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { 
                            y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // --- Pie Chart (Distribusi Lokasi) ---
            const canvasLoc = document.getElementById('locChart');
            const locLabels = {!! json_encode($lokasiData->map(function($item) { return $item->lokasiTambang->nama_lokasi ?? 'N/A'; })) !!};
            const locValues = {!! json_encode($lokasiData->pluck('total')) !!};

            if (canvasLoc && locLabels.length > 0) {
                const locCtx = canvasLoc.getContext('2d');
                new Chart(locCtx, {
                    type: 'pie',
                    data: {
                        labels: locLabels,
                        datasets: [{
                            data: locValues,
                            // Warna Hijau sesuai gambar yang Anda kirim
                            backgroundColor: ['#2D5A43', '#66D391', '#D1FAE5'], 
                            borderWidth: 4, // Memberi jarak putih antar slice (seperti di gambar)
                            borderColor: '#ffffff'
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { display: false } 
                        }
                    }
                });
            }
        });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const hari = @json($hariArray);
        const planData = @json($planData);
        const actualData = @json($actualData);
        const achievementData = @json($achievementData);

        // 2. Ambil elemen Canvas
        const ctx = document.getElementById('produksiChart').getContext('2d');

        // 3. Render Chart
        new Chart(ctx, {
            type: 'bar', // Tipe dasar grafik
            data: {
                labels: hari,
                datasets: [
                    {
                        label: 'PLAN',
                        data: planData,
                        backgroundColor: '#00BFFF', // Biru Terang
                        yAxisID: 'y', // Menggunakan sumbu Y Kiri
                        order: 2 // Urutan tumpukan (di belakang garis)
                    },
                    {
                        label: 'ACTUAL',
                        data: actualData,
                        backgroundColor: '#000000', // Hitam
                        yAxisID: 'y', // Menggunakan sumbu Y Kiri
                        order: 3
                    },
                    {
                        label: 'ACHIEVEMENT %',
                        data: achievementData,
                        type: 'line', // Ubah tipe khusus untuk dataset ini menjadi Garis
                        borderColor: '#FF0000', // Merah
                        backgroundColor: '#FF0000',
                        borderWidth: 2,
                        tension: 0, // 0 = Garis lurus patah-patah seperti di Excel
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        yAxisID: 'y1', // Menggunakan sumbu Y Kanan
                        order: 1 // Tampilkan di posisi paling depan
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            // Tambahkan simbol % pada tooltip khusus untuk Achievement
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += context.parsed.y;
                                    if (context.dataset.yAxisID === 'y1') { label += '%'; }
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Tanggal' },
                        grid: { display: false } // Hilangkan garis grid vertikal agar bersih
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'Volume' },
                        suggestedMax: 2500,
                        ticks: {
                            // Format angka ribuan (titik)
                            callback: function(value) {
                                return value.toLocaleString('id-ID');
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: { display: true, text: 'Achievement (%)' },
                        suggestedMax: 180,
                        grid: { 
                            drawOnChartArea: false // Jangan tumpuk garis grid Y kanan dengan Y kiri
                        },
                        ticks: {
                            // Tambahkan simbol %
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    });
    </script>
</x-app-layout>