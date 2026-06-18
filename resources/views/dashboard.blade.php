<x-app-layout>
    <div class="space-y-6">
        
        <!-- Welcome Message (Visible on smaller screens if needed, otherwise hidden by layout) -->
        <div class="flex items-center gap-2 mb-2 lg:hidden">
            <h2 class="text-3xl font-bold text-gray-900 leading-tight">
                Welcome Back,<br>
                {{ explode(' ', Auth::user()->nama_lengkap)[0] }} <span class="text-3xl">👋</span>
            </h2>
        </div>

        <!-- 1. The 3 Summary Cards (From Original) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-[#18181b] p-6 rounded-[24px] shadow-sm border border-gray-100/50 dark:border-[#27272a] flex justify-between items-center hover:shadow-md transition">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide transition-colors">Total Produksi (BCM)</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1 transition-colors">{{ number_format($totalProduksi, 0, ',', '.') }}</h3>
                    <p class="text-xs mt-2 font-bold {{ $growthProduksi >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $growthProduksi >= 0 ? '▲' : '▼' }} {{ number_format(abs($growthProduksi), 1) }}% 
                        <span class="text-gray-400 dark:text-gray-500 font-medium transition-colors">vs bulan sebelumnya</span>
                    </p>
                </div>
                <div class="bg-emerald-50 dark:bg-emerald-500/10 p-4 rounded-2xl text-emerald-500 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>

            <div class="bg-white dark:bg-[#18181b] p-6 rounded-[24px] shadow-sm border border-gray-100/50 dark:border-[#27272a] flex justify-between items-center hover:shadow-md transition">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide transition-colors">Laporan Disetujui</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1 transition-colors">{{ $laporanDisetujui }}</h3>
                    <p class="text-xs mt-2 font-bold {{ $growthLaporan >= 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $growthLaporan >= 0 ? '▲' : '▼' }} {{ number_format(abs($growthLaporan), 1) }}% 
                        <span class="text-gray-400 dark:text-gray-500 font-medium transition-colors">vs bulan sebelumnya</span>
                    </p>
                </div>
                <div class="bg-blue-50 dark:bg-blue-500/10 p-4 rounded-2xl text-blue-500 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white dark:bg-[#18181b] p-6 rounded-[24px] shadow-sm border border-gray-100/50 dark:border-[#27272a] flex justify-between items-center hover:shadow-md transition">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide transition-colors">Ditolak / Menunggu</p>
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white mt-1 transition-colors"><span class="text-red-500">{{ $laporanDitolak }}</span> / <span class="text-amber-500">{{ $laporanPending }}</span></h3>
                    <p class="text-xs text-amber-500 mt-2 font-bold">▲ {{ number_format($percPending, 1) }}% <span class="text-gray-400 dark:text-gray-500 font-medium transition-colors">laporan pending</span></p>
                </div>
                <div class="bg-amber-50 dark:bg-amber-500/10 p-4 rounded-2xl text-amber-500 transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <!-- LEFT COLUMN (Span 2) -->
            <div class="xl:col-span-2 space-y-6 flex flex-col">
                
                <!-- 1. Total Profit Overview (Grafik Produksi Harian) -->
                <div class="bg-white dark:bg-[#18181b] rounded-[24px] p-6 lg:p-8 shadow-sm border border-gray-100/50 dark:border-[#27272a] flex-none transition-colors">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-6 gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-orange-500/10 dark:bg-orange-500/20 flex items-center justify-center text-orange-500 dark:text-orange-400 shadow-sm border border-orange-500/20 dark:border-orange-500/30 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <h3 class="font-extrabold text-xl text-gray-900 dark:text-white transition-colors">{{ $chartTitle }}</h3>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Helper function to update URL params -->
                            <script>
                                function updateChartFilter(key, value) {
                                    const url = new URL(window.location.href);
                                    if(value) {
                                        url.searchParams.set(key, value);
                                    } else {
                                        url.searchParams.delete(key);
                                    }
                                    window.location.href = url.toString();
                                }
                                function exportProdChart() {
                                    const link = document.createElement('a');
                                    link.download = 'grafik-produksi.png';
                                    link.href = document.getElementById('prodChart').toDataURL('image/png', 1.0);
                                    link.click();
                                }
                                function exportGaugeChart() {
                                    const link = document.createElement('a');
                                    link.download = 'performa-target.png';
                                    link.href = document.getElementById('gaugeChart').toDataURL('image/png', 1.0);
                                    link.click();
                                }
                            </script>
                            <div class="relative">
                                <select onchange="updateChartFilter('range', this.value)" class="bg-gray-50 dark:bg-white/5 border-none text-sm font-bold text-gray-700 dark:text-white rounded-full pl-4 pr-10 py-2 focus:ring-0 appearance-none transition-colors cursor-pointer w-full">
                                    <option value="30" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $range == 30 ? 'selected' : '' }}>Bulan</option>
                                    <option value="7" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $range == 7 ? 'selected' : '' }}>Minggu</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            
                            <!-- Filter Location Dropdown Container -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.outside="open = false" class="w-10 h-10 rounded-full {{ $lokasi_id ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400' : 'bg-gray-50 text-gray-500 dark:bg-white/5 dark:text-gray-400' }} flex items-center justify-center hover:bg-gray-100 dark:hover:bg-white/10 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                </button>
                                <!-- Filter Menu -->
                                <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#18181b] rounded-xl shadow-lg border border-gray-100 dark:border-[#27272a] py-2 z-50">
                                    <div class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Filter Lokasi</div>
                                    <a href="#" onclick="updateChartFilter('lokasi_id', ''); return false;" class="block px-4 py-2 text-sm {{ !$lokasi_id ? 'text-indigo-600 dark:text-indigo-400 font-bold bg-gray-50 dark:bg-white/5' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5' }}">Semua Lokasi</a>
                                    @foreach($daftarLokasi as $lok)
                                        <a href="#" onclick="updateChartFilter('lokasi_id', '{{ $lok->id }}'); return false;" class="block px-4 py-2 text-sm {{ $lokasi_id == $lok->id ? 'text-indigo-600 dark:text-indigo-400 font-bold bg-gray-50 dark:bg-white/5' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5' }}">{{ $lok->nama_lokasi }}</a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Export Data Button -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.outside="open = false" class="w-10 h-10 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </button>
                                <!-- Export Menu -->
                                <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#18181b] rounded-xl shadow-lg border border-gray-100 dark:border-[#27272a] py-2 z-50">
                                    <a href="#" onclick="exportProdChart(); open = false; return false;" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download PNG
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white transition-colors">{{ number_format($displayTotal, 0, ',', '.') }} <span class="text-lg text-gray-400 dark:text-gray-500 font-medium transition-colors">BCM</span></h2>
                        <p class="text-sm font-bold {{ $displayGrowth >= 0 ? 'text-emerald-500' : 'text-red-500' }} mt-2 flex items-center gap-1">
                            {{ $displayGrowth >= 0 ? '+' : '' }}{{ number_format($displayGrowth, 1) }}% {{ $displayGrowth >= 0 ? '↗' : '↘' }} <span class="text-gray-400 dark:text-gray-500 font-medium ml-1 transition-colors">{{ $displayCompareText }}</span>
                        </p>
                    </div>

                    <div class="relative h-64 w-full">
                        <canvas id="prodChart"></canvas>
                    </div>
                </div>

                <!-- 2. Recent Transaction (Laporan Menunggu Verifikasi) -->
                <div class="bg-white dark:bg-[#18181b] rounded-[24px] p-6 lg:p-8 shadow-sm border border-gray-100/50 dark:border-[#27272a] flex-1 flex flex-col transition-colors">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-600 dark:text-gray-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white transition-colors">Laporan Menunggu Verifikasi</h3>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="relative">
                                <select onchange="updateChartFilter('status_pending', this.value);" class="bg-gray-50 dark:bg-white/5 border-none text-sm font-bold text-gray-700 dark:text-white rounded-full pl-4 pr-10 py-2 focus:ring-0 appearance-none cursor-pointer transition-colors w-full">
                                    <option value="all" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ request('status_pending') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="Pending" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ request('status_pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Ditolak" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ request('status_pending') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <button onclick="exportPendingTable();" class="bg-[#18181b] dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-200 text-white dark:text-[#18181b] text-sm font-bold px-5 py-2.5 rounded-full flex items-center gap-2 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Ekspor
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto custom-scrollbar pb-2">
                        <table class="w-full text-left border-collapse min-w-[700px]">
                            <thead>
                                <tr class="text-gray-400 text-xs uppercase tracking-wider font-bold border-b border-gray-100 dark:border-[#27272a]">
                                    <th class="pb-4 font-bold"><input type="checkbox" class="rounded text-[#18181b] dark:text-gray-400 border-gray-300 dark:border-gray-600 dark:bg-transparent focus:ring-[#18181b] dark:focus:ring-white"> Operator</th>
                                    <th class="pb-4 font-bold">Lokasi / Alat</th>
                                    <th class="pb-4 font-bold">Waktu</th>
                                    <th class="pb-4 font-bold text-right">Volume</th>
                                    <th class="pb-4 font-bold text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-[#27272a]">
                                @forelse($laporanPendingHariIni as $pending)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <input type="checkbox" class="rounded text-[#18181b] dark:text-gray-400 border-gray-300 dark:border-gray-600 dark:bg-transparent focus:ring-[#18181b] dark:focus:ring-white">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pending->user->nama_lengkap ?? 'U') }}&background=random&color=fff" class="w-8 h-8 rounded-full">
                                            <span class="font-bold text-gray-900 dark:text-white text-sm transition-colors">{{ $pending->user->nama_lengkap ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="font-bold text-gray-900 dark:text-white text-sm transition-colors">{{ $pending->lokasiTambang->nama_lokasi ?? '-' }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors">{{ $pending->alatTambang->nama_alat ?? '-' }}</div>
                                    </td>
                                    <td class="py-4 font-medium text-gray-600 dark:text-gray-400 text-sm transition-colors">
                                        {{ \Carbon\Carbon::parse($pending->tanggal)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="py-4 font-bold text-gray-900 dark:text-white text-sm text-right transition-colors">
                                        {{ number_format($pending->volume, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 text-center">
                                        <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-bold">Pending</span>
                                    </td>
                                </tr>
                                 @empty
                                 <tr>
                                     <td colspan="5" class="py-8 text-center text-sm text-gray-500 border-2 border-dashed border-gray-100 dark:border-gray-800 rounded-xl">
                                         Tidak ada laporan yang menunggu verifikasi.
                                     </td>
                                 </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (Span 1) -->
            <div class="space-y-6">
                
                <!-- 3. Sales Performance (Target Produksi) -->
                <div class="bg-white dark:bg-[#18181b] rounded-[24px] p-6 lg:p-8 shadow-sm border border-gray-100/50 dark:border-[#27272a] flex flex-col items-center transition-colors">
                    <div class="w-full flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-600 dark:text-gray-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white transition-colors">Performa Target</h3>
                        </div>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" class="w-8 h-8 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                            </button>
                            <!-- Export Menu -->
                            <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#18181b] rounded-xl shadow-lg border border-gray-100 dark:border-[#27272a] py-2 z-50">
                                <a href="#" onclick="exportGaugeChart(); open = false; return false;" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download PNG
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Gauge Chart Container -->
                    <div class="relative w-full aspect-[2/1.2] overflow-hidden flex justify-center mb-4">
                        <canvas id="gaugeChart" class="w-full h-full object-contain"></canvas>
                        <div class="absolute bottom-4 left-0 right-0 text-center">
                            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white transition-colors">80%</h2>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 mt-1 transition-colors">Target Tahunan</p>
                        </div>
                    </div>

                    <div class="w-full grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 mb-1 flex items-center justify-between transition-colors">Realisasi <span class="bg-green-100 dark:bg-green-500/10 text-green-600 dark:text-green-400 px-1.5 py-0.5 rounded text-[9px]">++6%</span></p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white transition-colors">{{ number_format($totalProduksi, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-500 mb-1 flex items-center justify-between transition-colors">Target <span class="bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 px-1.5 py-0.5 rounded text-[9px]">-2%</span></p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white transition-colors">12,500,000</p>
                        </div>
                    </div>

                    <div x-data="{ showNotice: true }" x-show="showNotice" class="w-full mt-6 bg-[#18181b] dark:bg-[#27272a] rounded-2xl p-4 flex items-center justify-between shadow-lg transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-orange-500/20 text-orange-500 flex items-center justify-center text-lg">📣</div>
                            <p class="text-white text-xs font-medium">Produksi harian meningkat</p>
                        </div>
                        <button @click="showNotice = false" class="text-gray-400 hover:text-white"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                </div>

                <!-- 4. Top Market (Distribusi Lokasi) -->
                <div class="bg-white dark:bg-[#18181b] rounded-[24px] p-6 shadow-sm border border-gray-100/50 dark:border-[#27272a] transition-colors">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-white/5 flex items-center justify-center text-emerald-600 dark:text-gray-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white transition-colors">Distribusi Lokasi</h3>
                        </div>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" class="w-8 h-8 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                            </button>
                            <!-- Export Menu -->
                            <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#18181b] rounded-xl shadow-lg border border-gray-100 dark:border-[#27272a] py-2 z-50">
                                <a href="{{ route('laporan.riwayat') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    Lihat Detail Laporan
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($lokasiData->take(3) as $index => $ld)
                        @php
                            $colors = ['bg-red-500', 'bg-yellow-500', 'bg-green-500'];
                            $borderColors = ['border-red-500', 'border-yellow-500', 'border-green-500'];
                            $bgColors = ['bg-red-50 dark:bg-red-500/10', 'bg-yellow-50 dark:bg-yellow-500/10', 'bg-green-50 dark:bg-green-500/10'];
                            $textColors = ['text-red-600 dark:text-red-400', 'text-yellow-600 dark:text-yellow-400', 'text-green-600 dark:text-green-400'];
                            $colorIdx = $index % 3;
                            $percentage = $totalProduksi > 0 ? round(($ld->total / $totalProduksi) * 100) : 0;
                        @endphp
                        <div class="flex items-center justify-between border border-gray-100 dark:border-[#27272a] rounded-[20px] p-3 hover:shadow-sm transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center overflow-hidden border {{ $borderColors[$colorIdx] }} bg-white dark:bg-[#18181b] relative transition-colors">
                                    <!-- A colored slice to simulate flag -->
                                    <div class="absolute left-0 top-0 bottom-0 w-1/3 {{ $colors[$colorIdx] }}"></div>
                                    <div class="absolute left-1/3 top-0 bottom-0 right-0 bg-white dark:bg-[#18181b] transition-colors"></div>
                                </div>
                                <span class="font-bold text-sm text-gray-800 dark:text-gray-300 transition-colors">{{ $ld->lokasiTambang->nama_lokasi ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-sm text-gray-900 dark:text-white transition-colors">{{ number_format($ld->total, 0, ',', '.') }}</span>
                                <span class="{{ $bgColors[$colorIdx] }} {{ $textColors[$colorIdx] }} text-[10px] font-extrabold px-2 py-1 rounded-full transition-colors">{{ $percentage }}%</span>
                            </div>
                        </div>
                        @endforeach
                        
                        @if(count($lokasiData) == 0)
                            <!-- Mock Data -->
                            <div class="flex items-center justify-between border border-gray-100 rounded-[20px] p-3 hover:shadow-sm transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full border border-red-500 overflow-hidden flex relative">
                                        <div class="w-1/2 h-full bg-red-500"></div><div class="w-1/2 h-full bg-white"></div>
                                    </div>
                                    <span class="font-bold text-sm text-gray-800">PIT Kancil</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-sm text-gray-900">62,100</span>
                                    <span class="bg-red-50 text-red-600 text-[10px] font-extrabold px-2 py-1 rounded-full">40%</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between border border-gray-100 rounded-[20px] p-3 hover:shadow-sm transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full border border-yellow-500 overflow-hidden flex relative">
                                        <div class="w-full h-1/3 bg-black"></div><div class="w-full h-1/3 bg-red-500 top-1/3 absolute"></div><div class="w-full h-1/3 bg-yellow-500 bottom-0 absolute"></div>
                                    </div>
                                    <span class="font-bold text-sm text-gray-800">PIT Rusa</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-sm text-gray-900">24,500</span>
                                    <span class="bg-yellow-50 text-yellow-600 text-[10px] font-extrabold px-2 py-1 rounded-full">25%</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 5. Top Product (Top Operator) -->
                <div class="bg-gradient-to-br from-[#f8f9fa] to-white dark:from-[#18181b] dark:to-[#09090b] rounded-[24px] p-6 shadow-sm border border-gray-100/50 dark:border-[#27272a] transition-colors">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-white dark:bg-white/5 flex items-center justify-center text-gray-600 dark:text-gray-400 shadow-sm border border-gray-100 dark:border-transparent transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white transition-colors">Operator Terbaik</h3>
                        </div>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" class="w-8 h-8 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#18181b] rounded-xl shadow-lg border border-gray-100 dark:border-[#27272a] py-2 z-50">
                                <a href="{{ route('manajemen.users') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    Lihat Semua Operator
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        @foreach($topOperators->take(2) as $index => $operator)
                            @if($index == 0)
                                <!-- Card Dark -->
                                <div class="bg-[#18181b] rounded-2xl p-4 shadow-xl relative overflow-hidden flex flex-col min-h-[160px]">
                                    <!-- Mock pattern background: slanted lines -->
                                    <div class="absolute inset-0 opacity-20" style="background: repeating-linear-gradient(45deg, transparent, transparent 5px, rgba(255,255,255,0.1) 5px, rgba(255,255,255,0.1) 10px);"></div>
                                    
                                    <div class="relative z-10 flex flex-col h-full">
                                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center mb-auto shadow-lg">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($operator->user->nama_lengkap ?? 'O') }}&background=random&color=fff" class="w-full h-full rounded-full">
                                        </div>
                                        <div class="mt-4">
                                            <h4 class="text-white font-bold text-sm leading-tight line-clamp-2">{{ $operator->user->nama_lengkap ?? 'N/A' }}</h4>
                                            <p class="text-gray-400 text-[10px] mt-1 font-medium flex flex-wrap items-center gap-1">{{ number_format($operator->total_volume ?? 0, 0) }} BCM <span class="text-green-400 font-bold">+17%</span></p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Card Light -->
                                <div class="bg-white dark:bg-[#27272a] border border-gray-100 dark:border-transparent rounded-2xl p-4 shadow-sm relative overflow-hidden flex flex-col min-h-[160px] transition-colors">
                                    <!-- Mock pattern background -->
                                    <div class="absolute inset-0 opacity-[0.03] dark:opacity-10" style="background-image: radial-gradient(#000 2px, transparent 2px); background-size: 15px 15px;"></div>
                                    
                                    <div class="relative z-10 flex flex-col h-full">
                                        <div class="w-8 h-8 rounded-full bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-transparent flex items-center justify-center mb-auto shadow-sm transition-colors">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($operator->user->nama_lengkap ?? 'H') }}&background=random&color=fff" class="w-full h-full rounded-full">
                                        </div>
                                        <div class="mt-4">
                                            <h4 class="text-gray-900 dark:text-white font-bold text-sm leading-tight transition-colors line-clamp-2">{{ $operator->user->nama_lengkap ?? 'N/A' }}</h4>
                                            <p class="text-gray-500 dark:text-gray-400 text-[10px] mt-1 font-medium transition-colors flex flex-wrap items-center gap-1">{{ number_format($operator->total_volume ?? 0, 0) }} BCM <span class="text-green-500 font-bold">+6%</span></p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if(count($topOperators) == 0)
                            <div class="col-span-2 text-center text-sm text-gray-500 py-8 border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-2xl">Belum ada data produksi disetujui.</div>
                        @elseif(count($topOperators) == 1)
                            <div></div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- 6. Target vs Realisasi Produksi (The Big Bar/Line Chart) -->
        <div class="bg-white dark:bg-[#18181b] rounded-[24px] p-6 lg:p-8 shadow-sm border border-gray-100/50 dark:border-[#27272a] transition-colors">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/20 flex items-center justify-center text-indigo-500 dark:text-indigo-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white transition-colors">Target vs Realisasi Produksi (BCM)</h3>
                </div>
                
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <select name="bulan" onchange="updateChartFilter('bulan', this.value)" class="bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-[#27272a] text-sm font-bold text-gray-700 dark:text-white rounded-full pl-4 pr-10 py-2 focus:ring-0 appearance-none cursor-pointer transition-colors w-full">
                            <option value="01" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $bulan == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select name="tahun" onchange="updateChartFilter('tahun', this.value)" class="bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-[#27272a] text-sm font-bold text-gray-700 dark:text-white rounded-full pl-4 pr-10 py-2 focus:ring-0 appearance-none cursor-pointer transition-colors w-full">
                            @foreach($tahunTersedia as $t)
                                <option value="{{ $t }}" class="bg-white dark:bg-[#18181b] text-gray-900 dark:text-white" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div style="position: relative; height:400px; width:100%">
                <canvas id="produksiChart"></canvas>
            </div>
        </div>

        <!-- 7. Data Table Produksi -->
        <div class="bg-white dark:bg-[#18181b] rounded-[24px] shadow-sm border border-gray-100/50 dark:border-[#27272a] flex flex-col h-full overflow-hidden transition-colors">
            <div class="px-6 py-5 border-b border-gray-100/50 dark:border-[#27272a] flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white transition-colors">Daftar Laporan Produksi</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-1 transition-colors">Data terbaru laporan masuk harian</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead class="bg-gray-50/50 dark:bg-white/5 transition-colors">
                        <tr class="text-[11px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-[#27272a] transition-colors">
                            <th class="px-6 py-4 whitespace-nowrap">Tanggal</th>
                            <th class="px-6 py-4">Shift</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4">Alat Berat</th>
                            <th class="px-6 py-4 text-right">Volume</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-[#27272a] bg-white dark:bg-transparent transition-colors">
                        @forelse($laporanProduksi as $lp)
                        <tr class="text-xs text-gray-600 dark:text-gray-400 hover:bg-gray-50/80 dark:hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800 dark:text-gray-300 transition-colors">
                                {{ \Carbon\Carbon::parse($lp->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-600 dark:text-gray-400 transition-colors">Shift 1</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold uppercase text-gray-800 dark:text-gray-300 transition-colors">{{ $lp->lokasiTambang->nama_lokasi ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-gray-900 dark:text-white leading-tight transition-colors">{{ $lp->alatTambang->nama_alat ?? 'Exca-01' }}</div>
                                <div class="text-[10px] text-gray-400 dark:text-gray-500 font-medium italic transition-colors">({{ $lp->alatTambang->tipe_alat ?? 'Excavator' }})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-right text-sm text-emerald-600">
                                {{ number_format($lp->volume, 0, ',', '.') }} <span class="text-[10px] font-medium text-gray-400">BCM</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic text-sm">
                                Data untuk hari ini belum tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50/30 dark:bg-white/5 border-t border-gray-50 dark:border-[#27272a] flex flex-col sm:flex-row justify-between items-center gap-4 transition-colors">
                <p class="text-xs text-gray-500 dark:text-gray-400 font-bold transition-colors">
                    Tampil {{ $laporanProduksi->firstItem() ?? 0 }}-{{ $laporanProduksi->lastItem() ?? 0 }} dari {{ $laporanProduksi->total() }}
                </p>
                <div class="flex items-center gap-2">
                    @if ($laporanProduksi->onFirstPage())
                        <span class="px-3 py-1.5 bg-gray-100 dark:bg-white/5 rounded-lg text-gray-400 dark:text-gray-600 text-xs font-bold cursor-not-allowed transition-colors">Prev</span>
                    @else
                        <a href="{{ $laporanProduksi->previousPageUrl() }}" class="px-3 py-1.5 bg-white dark:bg-[#18181b] border border-gray-200 dark:border-[#27272a] rounded-lg text-gray-600 dark:text-gray-400 text-xs font-bold hover:bg-gray-50 dark:hover:bg-white/10 transition-colors shadow-sm">Prev</a>
                    @endif

                    <span class="px-3 py-1.5 bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] rounded-lg font-bold text-xs shadow-md transition-colors">{{ $laporanProduksi->currentPage() }}</span>

                    @if ($laporanProduksi->hasMorePages())
                        <a href="{{ $laporanProduksi->nextPageUrl() }}" class="px-3 py-1.5 bg-white dark:bg-[#18181b] border border-gray-200 dark:border-[#27272a] rounded-lg text-gray-600 dark:text-gray-400 text-xs font-bold hover:bg-gray-50 dark:hover:bg-white/10 transition-colors shadow-sm">Next</a>
                    @else
                        <span class="px-3 py-1.5 bg-gray-100 dark:bg-white/5 rounded-lg text-gray-400 dark:text-gray-600 text-xs font-bold cursor-not-allowed transition-colors">Next</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js configuration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            
            const isDark = () => document.documentElement.classList.contains('dark');
            const getColor = (light, dark) => isDark() ? dark : light;
            
            let prodChartInstance = null;
            let gaugeChartInstance = null;
            let produksiChartInstance = null;

            // --- 1. Bar Chart (Total Profit Overview) ---
            const canvasProd = document.getElementById('prodChart');
            const dataLabels = {!! json_encode($chartLabels) !!};
            const dataValues = {!! json_encode($chartData) !!};

            if (canvasProd) {
                // If no real data, use mock data to match design
                const labels = dataLabels.length > 0 ? dataLabels : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'];
                const values = dataValues.length > 0 ? dataValues : [40000, 30000, 45000, 95000, 35000, 60000, 42000];
                
                const prodCtx = canvasProd.getContext('2d');
                prodChartInstance = new Chart(prodCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Volume (BCM)',
                            data: values,
                            backgroundColor: function(context) {
                                const index = context.dataIndex;
                                // Highlight the highest value (like April in design)
                                const maxValue = Math.max(...context.dataset.data);
                                if (context.dataset.data[index] === maxValue) {
                                    // Use a pattern or dark color
                                    return getColor('#18181b', '#ffffff'); 
                                }
                                return getColor('#f8f9fa', 'rgba(255,255,255,0.05)'); // very light gray / dark fade
                            },
                            borderRadius: 20, // pill shape
                            borderSkipped: false,
                            barPercentage: 0.6,
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false,
                        plugins: { 
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#18181b',
                                titleFont: { size: 14, family: "'Plus Jakarta Sans', sans-serif", weight: 'bold' },
                                bodyFont: { size: 13, family: "'Plus Jakarta Sans', sans-serif", weight: '500' },
                                padding: 16,
                                cornerRadius: 16,
                                displayColors: true,
                                boxPadding: 6,
                                yAlign: 'bottom',
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) { label += ': '; }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: { 
                            y: { 
                                beginAtZero: true, 
                                grid: { color: () => getColor('#f8f9fa', 'rgba(255,255,255,0.05)'), drawBorder: false },
                                border: { display: false, dash: [5, 5] },
                                ticks: {
                                    font: { weight: 'bold', color: '#9ca3af' },
                                    callback: function(value) { return value >= 1000 ? (value/1000) + 'K' : value; },
                                    padding: 10
                                }
                            },
                            x: { 
                                grid: { display: false, drawBorder: false },
                                border: { display: false },
                                ticks: { font: { weight: 'bold', color: '#9ca3af' }, padding: 10 }
                            }
                        }
                    }
                });
            }

            // --- 2. Gauge Chart (Sales Performance) ---
            const canvasGauge = document.getElementById('gaugeChart');
            if (canvasGauge) {
                const gaugeCtx = canvasGauge.getContext('2d');
                gaugeChartInstance = new Chart(gaugeCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Achieved', 'Remaining'],
                        datasets: [{
                            data: [80, 20],
                            backgroundColor: ['#22c55e', getColor('#f3f4f6', 'rgba(255,255,255,0.1)')], // Green and light gray
                            borderWidth: 0, // Removed border for cleaner look like in design
                            borderRadius: 10,
                            spacing: 5 // space between slices
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        circumference: 180, // Half circle
                        rotation: -90, // Start from left
                        cutout: '75%', // Thickness of the doughnut
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        }
                    }
                });
            }

            // --- 3. Target vs Realisasi (Bar + Line) ---
            const ctxProduksi = document.getElementById('produksiChart');
            if (ctxProduksi) {
                const hari = @json($hariArray);
                const planData = @json($planData);
                const actualData = @json($actualData);
                const achievementData = @json($achievementData);

                produksiChartInstance = new Chart(ctxProduksi, {
                    type: 'bar', // Tipe dasar grafik
                    data: {
                        labels: hari,
                        datasets: [
                            {
                                label: 'PLAN',
                                data: planData,
                                backgroundColor: getColor('#f3f4f6', 'rgba(255,255,255,0.1)'), // Light gray
                                borderRadius: 4,
                                yAxisID: 'y', // Menggunakan sumbu Y Kiri
                                order: 2 // Urutan tumpukan (di belakang garis)
                            },
                            {
                                label: 'ACTUAL',
                                data: actualData,
                                backgroundColor: getColor('#18181b', '#ffffff'), // Hitam / Putih
                                borderRadius: 4,
                                yAxisID: 'y', // Menggunakan sumbu Y Kiri
                                order: 3
                            },
                            {
                                label: 'ACHIEVEMENT %',
                                data: achievementData,
                                type: 'line', // Ubah tipe khusus untuk dataset ini menjadi Garis
                                borderColor: '#10b981', // Emerald
                                backgroundColor: '#10b981',
                                borderWidth: 3,
                                tension: 0.3, // Curve
                                pointRadius: 4,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#10b981',
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
                                labels: {
                                    font: { family: "'Plus Jakarta Sans', sans-serif", weight: 'bold' },
                                    usePointStyle: true,
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: '#18181b',
                                titleFont: { size: 14, family: "'Plus Jakarta Sans', sans-serif", weight: 'bold' },
                                bodyFont: { size: 13, family: "'Plus Jakarta Sans', sans-serif", weight: '500' },
                                padding: 16,
                                cornerRadius: 16,
                                displayColors: true,
                                boxPadding: 6,
                                callbacks: {
                                    // Tambahkan simbol % pada tooltip khusus untuk Achievement
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) { label += ': '; }
                                        if (context.parsed.y !== null) {
                                            if (context.dataset.yAxisID === 'y1') { 
                                                label += context.parsed.y + '%'; 
                                            } else {
                                                label += new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                            }
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: { display: false },
                                grid: { display: false, drawBorder: false }, 
                                ticks: { font: { weight: 'bold', color: '#9ca3af' } }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: { display: false },
                                suggestedMax: 2500,
                                grid: { color: () => getColor('#f8f9fa', 'rgba(255,255,255,0.05)'), drawBorder: false },
                                border: { display: false, dash: [5, 5] },
                                ticks: {
                                    font: { weight: 'bold', color: '#9ca3af' },
                                    callback: function(value) {
                                        return value >= 1000 ? (value/1000) + 'K' : value;
                                    }
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: { display: false },
                                suggestedMax: 180,
                                grid: { drawOnChartArea: false },
                                border: { display: false },
                                ticks: {
                                    font: { weight: 'bold', color: '#9ca3af' },
                                    callback: function(value) { return value + '%'; }
                                }
                            }
                        }
                    }
                });
            }

            // --- Theme Observer for Charts ---
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class') {
                        if (prodChartInstance) prodChartInstance.update();
                        if (gaugeChartInstance) {
                            gaugeChartInstance.data.datasets[0].backgroundColor[1] = getColor('#f3f4f6', 'rgba(255,255,255,0.1)');
                            gaugeChartInstance.update();
                        }
                        if (produksiChartInstance) {
                            produksiChartInstance.data.datasets[0].backgroundColor = getColor('#f3f4f6', 'rgba(255,255,255,0.1)');
                            produksiChartInstance.data.datasets[1].backgroundColor = getColor('#18181b', '#ffffff');
                            produksiChartInstance.update();
                        }
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true });
        });
    </script>
</x-app-layout>