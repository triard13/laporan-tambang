<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Analisis & Keputusan') }}
            </h2>
            
            <form action="{{ route('analisis.index') }}" method="GET" class="flex gap-3">
                <select name="bulan" onchange="this.form.submit()" class="bg-white dark:bg-[#18181b] border-gray-200 dark:border-[#27272a] text-sm rounded-xl focus:ring-emerald-500">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
                
                <select name="tahun" onchange="this.form.submit()" class="bg-white dark:bg-[#18181b] border-gray-200 dark:border-[#27272a] text-sm rounded-xl focus:ring-emerald-500">
                    @foreach(range(date('Y')-2, date('Y')) as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Operator & Cuaca Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Kinerja Operator Chart -->
                <div class="bg-white dark:bg-[#18181b] overflow-hidden shadow-sm rounded-3xl p-6 border border-gray-100 dark:border-[#27272a]">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Top Kinerja Operator (Volume BCM)</h3>
                    <div class="h-64 relative w-full">
                        <canvas id="operatorChart"></canvas>
                    </div>
                </div>

                <!-- Cuaca dan Hambatan Chart -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-[#18181b] shadow-sm rounded-3xl p-6 border border-gray-100 dark:border-[#27272a]">
                        <h3 class="text-md font-bold text-gray-900 dark:text-white mb-4">Kondisi Cuaca Dominan</h3>
                        <div class="h-48 relative w-full">
                            <canvas id="cuacaChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-[#18181b] shadow-sm rounded-3xl p-6 border border-gray-100 dark:border-[#27272a]">
                        <h3 class="text-md font-bold text-gray-900 dark:text-white mb-4">Frekuensi Hambatan</h3>
                        <div class="h-48 relative w-full">
                            <canvas id="hambatanChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Efisiensi Alat Table -->
            <div class="bg-white dark:bg-[#18181b] shadow-sm rounded-3xl p-6 border border-gray-100 dark:border-[#27272a]">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Analisis Efisiensi Bahan Bakar Alat Tambang</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-white/5 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-4 rounded-l-2xl">Nama Alat</th>
                                <th scope="col" class="px-6 py-4 text-right">Total Volume (BCM)</th>
                                <th scope="col" class="px-6 py-4 text-right">Total BBM (Liter)</th>
                                <th scope="col" class="px-6 py-4 text-center">Rasio (Liter/BCM)</th>
                                <th scope="col" class="px-6 py-4 rounded-r-2xl">Status Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($efisiensiAlat as $alat)
                                <tr class="bg-white dark:bg-transparent border-b border-gray-50 dark:border-[#27272a]">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $alat['nama_alat'] }}
                                    </td>
                                    <td class="px-6 py-4 text-right">{{ number_format($alat['total_volume'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right">{{ number_format($alat['total_bbm'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 font-bold text-center">{{ number_format($alat['rasio'], 2, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        @if($alat['status'] == 'Boros / Perlu Cek')
                                            <span class="px-3 py-1 bg-red-100 text-red-600 dark:bg-red-500/20 rounded-full text-xs font-bold">{{ $alat['status'] }}</span>
                                        @elseif($alat['status'] == 'Sangat Efisien')
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 rounded-full text-xs font-bold">{{ $alat['status'] }}</span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-100 text-gray-600 dark:bg-white/10 rounded-full text-xs font-bold">{{ $alat['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada data operasional untuk dianalisis pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data Setup
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#9ca3af' : '#6b7280';
            const gridColor = isDark ? '#27272a' : '#f3f4f6';

            // Kinerja Operator Bar Chart
            const ctxOperator = document.getElementById('operatorChart');
            if(ctxOperator) {
                new Chart(ctxOperator, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($kinerjaOperator->pluck('nama_operator')) !!},
                        datasets: [{
                            label: 'Total Volume (BCM)',
                            data: {!! json_encode($kinerjaOperator->pluck('total_volume')) !!},
                            backgroundColor: '#10b981',
                            borderRadius: 6,
                            barThickness: 'flex',
                            maxBarThickness: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { grid: { color: gridColor }, ticks: { color: textColor } },
                            x: { grid: { display: false }, ticks: { color: textColor, maxRotation: 45, minRotation: 45 } }
                        },
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }

            // Cuaca Doughnut Chart
            const ctxCuaca = document.getElementById('cuacaChart');
            if(ctxCuaca) {
                new Chart(ctxCuaca, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($statistikCuaca->pluck('cuaca')) !!},
                        datasets: [{
                            data: {!! json_encode($statistikCuaca->pluck('total')) !!},
                            backgroundColor: ['#f59e0b', '#3b82f6', '#64748b', '#10b981'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { color: textColor, padding: 15, boxWidth: 12 } }
                        },
                        cutout: '70%'
                    }
                });
            }

            // Hambatan Pie Chart
            const ctxHambatan = document.getElementById('hambatanChart');
            if(ctxHambatan) {
                new Chart(ctxHambatan, {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($statistikHambatan->pluck('jenis_hambatan')) !!},
                        datasets: [{
                            data: {!! json_encode($statistikHambatan->pluck('total')) !!},
                            backgroundColor: ['#ef4444', '#f97316', '#eab308', '#8b5cf6', '#ec4899'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { color: textColor, padding: 15, boxWidth: 12 } }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
