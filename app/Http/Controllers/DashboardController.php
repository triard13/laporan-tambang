<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProduksiHarian;
use App\Models\LokasiTambang;
use Carbon\Carbon;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        
        // 1. Ambil input bulan & tahun (Default ke bulan & tahun saat ini)
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // --- DATA PERIODE SEKARANG (Bulan yang Dipilih) ---
        $currentMonth = Carbon::createFromDate($tahun, $bulan, 1);
        $startOfCurrentMonth = $currentMonth->copy()->startOfMonth();
        $endOfCurrentMonth = $currentMonth->copy()->endOfMonth();

        $totalProduksi = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfCurrentMonth, $endOfCurrentMonth])
            ->sum('volume');
        
        // 5. Data Hari Ini & Kemarin (Untuk perbandingan Harian)
        $totalProduksiHariIni = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereDate('tanggal', Carbon::today())
            ->sum('volume');

        $totalProduksiKemarin = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereDate('tanggal', Carbon::yesterday())
            ->sum('volume');
            
        $growthHarian = $totalProduksiKemarin > 0 ? (($totalProduksiHariIni - $totalProduksiKemarin) / $totalProduksiKemarin) * 100 : ($totalProduksiHariIni > 0 ? 100 : 0);

        // 6. Data Mingguan (Untuk perbandingan Mingguan)
        $startOfWeek = now()->subDays(6)->startOfDay();
        $currentWeekTotal = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->where('tanggal', '>=', $startOfWeek)
            ->sum('volume');

        $startOfPrevWeek = now()->subDays(13)->startOfDay();
        $endOfPrevWeek = now()->subDays(7)->endOfDay();
        $prevWeekTotal = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfPrevWeek, $endOfPrevWeek])
            ->sum('volume');
        
        $growthMingguan = $prevWeekTotal > 0 ? (($currentWeekTotal - $prevWeekTotal) / $prevWeekTotal) * 100 : ($currentWeekTotal > 0 ? 100 : 0);

        // (Data grafik harian berdasarkan range)
        $range = $request->get('range', 30); // Default ke 30 (Bulan)
        $lokasi_id = $request->get('lokasi_id');

        if ($range == 7) {
            $displayTotal = $currentWeekTotal;
            $displayGrowth = $growthMingguan;
            $displayCompareText = 'vs minggu sebelumnya';
        } else {
            $displayTotal = $totalProduksiHariIni;
            $displayGrowth = $growthHarian;
            $displayCompareText = 'vs hari sebelumnya';
        }

        $laporanDisetujui = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfCurrentMonth, $endOfCurrentMonth])
            ->count();
            
        $laporanPending = ProduksiHarian::where('status_laporan', 'Pending')
            ->whereBetween('tanggal', [$startOfCurrentMonth, $endOfCurrentMonth])
            ->count();
            
        $laporanDitolak = ProduksiHarian::where('status_laporan', 'Ditolak')
            ->whereBetween('tanggal', [$startOfCurrentMonth, $endOfCurrentMonth])
            ->count();
        $chartDataRawQuery = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfCurrentMonth, $endOfCurrentMonth]);
            
        if ($lokasi_id) {
            $chartDataRawQuery->where('lokasi_tambang_id', $lokasi_id);
        }

        $chartDataRaw = $chartDataRawQuery->select(DB::raw('DATE(tanggal) as date'), DB::raw('SUM(volume) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        $chartData = [];
        $chartLabels = [];

        if ($range == 7) {
            // Mingguan (Bulan ini dibagi per minggu: tgl 1-7, 8-14, 15-21, 22-28, 29-end)
            $weeks = [
                1 => ['start' => 1, 'end' => 7],
                2 => ['start' => 8, 'end' => 14],
                3 => ['start' => 15, 'end' => 21],
                4 => ['start' => 22, 'end' => 28],
                5 => ['start' => 29, 'end' => $endOfCurrentMonth->day],
            ];
            
            $namaBulan = $startOfCurrentMonth->translatedFormat('M');

            foreach ($weeks as $weekNum => $days) {
                if ($days['start'] > $endOfCurrentMonth->day) continue;

                $weekTotal = 0;
                for ($d = $days['start']; $d <= $days['end']; $d++) {
                    // Make sure not to exceed the days in month
                    if ($d > $endOfCurrentMonth->day) break;
                    
                    $dateStr = $startOfCurrentMonth->copy()->day($d)->format('Y-m-d');
                    if (isset($chartDataRaw[$dateStr])) {
                        $weekTotal += $chartDataRaw[$dateStr]->total;
                    }
                }
                
                $chartLabels[] = "Mg $weekNum";
                $chartData[] = $weekTotal;
            }
            $chartTitle = 'Produksi Mingguan';
        } else {
            // Harian (Semua hari dalam bulan ini)
            $daysInMonth = $endOfCurrentMonth->day;
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $dateObj = $startOfCurrentMonth->copy()->day($d);
                $dateStr = $dateObj->format('Y-m-d');
                
                $total = isset($chartDataRaw[$dateStr]) ? $chartDataRaw[$dateStr]->total : 0;
                
                $chartLabels[] = $dateObj->translatedFormat('d M');
                $chartData[] = $total;
            }
            $chartTitle = 'Produksi Harian';
        }

        // --- DATA PERIODE LALU (Bulan Sebelumnya) ---
        $lastMonth = $currentMonth->copy()->subMonth();
        $startOfLastMonth = $lastMonth->copy()->startOfMonth();
        $endOfLastMonth = $lastMonth->copy()->endOfMonth();

        $prodBulanLalu = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfLastMonth, $endOfLastMonth])
            ->sum('volume');

        $laporanDisetujuiBulanLalu = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        // --- HITUNG PERSENTASE AKTUAL ---
        // Rumus: ((Sekarang - Lalu) / Lalu) * 100
        $growthProduksi = $prodBulanLalu > 0 ? (($totalProduksi - $prodBulanLalu) / $prodBulanLalu) * 100 : ($totalProduksi > 0 ? 100 : 0);
        $growthLaporan = $laporanDisetujuiBulanLalu > 0 ? (($laporanDisetujui - $laporanDisetujuiBulanLalu) / $laporanDisetujuiBulanLalu) * 100 : ($laporanDisetujui > 0 ? 100 : 0);

        // Persentase laporan pending terhadap total bulan ini
        $totalLaporanMasuk = ProduksiHarian::whereBetween('tanggal', [$startOfCurrentMonth, $endOfCurrentMonth])->count();
        $percPending = $totalLaporanMasuk > 0 ? ($laporanPending / $totalLaporanMasuk) * 100 : 0;



        $daftarLokasi = LokasiTambang::orderBy('nama_lokasi', 'asc')->get();

        $lokasiData = ProduksiHarian::with('lokasiTambang')
            ->select('lokasi_tambang_id', DB::raw('SUM(volume) as total'))
            ->where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfCurrentMonth, $endOfCurrentMonth])
            ->groupBy('lokasi_tambang_id')->get();

        // Ambil data untuk tabel kiri dengan Pagination (misal 3 data per halaman)
        // Kita beri nama query string 'page_laporan' agar tidak bentrok dengan pagination lain
        // Ambil data untuk tabel kiri (hanya untuk hari ini) dengan Pagination
        $laporanProduksi = ProduksiHarian::with(['user', 'alatTambang'])
            ->where('status_laporan', 'Disetujui')
            ->whereDate('tanggal', \Carbon\Carbon::today()) // Tambahkan filter ini
            ->orderBy('created_at', 'desc')
            ->paginate(3, ['*'], 'page_laporan');

        // Top 5 Operator Terproduktif Bulan Ini
        $topOperators = ProduksiHarian::with('user')
            ->select('user_id', DB::raw('SUM(volume) as total_volume'))
            ->where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfCurrentMonth, $endOfCurrentMonth])
            ->groupBy('user_id')
            ->orderBy('total_volume', 'desc')
            ->limit(5)
            ->get();
        // Laporan Masuk (Pending & Ditolak)
        $status_pending = $request->get('status_pending', 'all');
        $pendingQuery = ProduksiHarian::with(['user', 'alatTambang', 'lokasiTambang'])
            ->whereBetween('tanggal', [$startOfCurrentMonth, $endOfCurrentMonth]);

        if ($status_pending === 'all') {
            $pendingQuery->where('status_laporan', '!=', 'Disetujui');
        } else {
            $pendingQuery->where('status_laporan', $status_pending);
        }

        $laporanPendingHariIni = $pendingQuery->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Hitung jumlah hari dalam bulan & tahun yang dipilih
        $jumlahHari = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

        $driver = DB::connection()->getDriverName();
        $dayRaw = $driver === 'sqlite' ? "CAST(strftime('%d', tanggal) AS INTEGER)" : 'DAY(tanggal)';
        $yearRaw = $driver === 'sqlite' ? "CAST(strftime('%Y', tanggal) AS INTEGER)" : 'YEAR(tanggal)';

        // 2. Tarik Data Aktual dari Database berdasarkan Bulan DAN Tahun
        $produksiAktual = ProduksiHarian::selectRaw("$dayRaw as hari, SUM(volume) as total_volume")
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status_laporan', 'Disetujui') // Filter Wajib!
            ->groupBy('hari')
            ->pluck('total_volume', 'hari')
            ->toArray();

        // 3. Ambil daftar TAHUN unik yang ada di tabel untuk Dropdown
        $tahunTersedia = ProduksiHarian::selectRaw("$yearRaw as tahun")
            ->distinct()
            ->orderBy('tahun', 'desc') // Urutkan tahun dari yang terbaru
            ->pluck('tahun');

        // Jika tabel masih kosong, minimal kita punya tahun saat ini
        if($tahunTersedia->isEmpty()) {
            $tahunTersedia = collect([date('Y')]);
        }

        // 4. Siapkan Array Kosong untuk Chart.js
        $hariArray = [];
        $planData = [];
        $actualData = [];
        $achievementData = [];

        // Simulasi Target: Rata-rata realisasi + 10%
        $actualsForAvg = array_filter($produksiAktual, function($val) { return $val > 0; });
        $avgActual = count($actualsForAvg) > 0 ? array_sum($actualsForAvg) / count($actualsForAvg) : 0;
        $targetHarian = $avgActual > 0 ? round($avgActual * 1.1) : 1250;

        for ($i = 1; $i <= $jumlahHari; $i++) {
            $hariArray[] = $i;
            
            $aktual = isset($produksiAktual[$i]) ? (float) $produksiAktual[$i] : 0;
            
            // Hanya tampilkan plan jika hari ini atau sebelumnya, atau jika ada data aktual
            // Tapi karena plan biasanya selalu ada sepanjang bulan, kita set plan statis
            $planData[] = $targetHarian;
            $actualData[] = $aktual;

            $persentase = $targetHarian > 0 ? round(($aktual / $targetHarian) * 100) : 0;
            $achievementData[] = $persentase;
        }

        return view('dashboard', compact(
            'totalProduksi', 'totalProduksiHariIni', 'laporanDisetujui', 'laporanPending', 'laporanDitolak', 
            'growthProduksi', 'growthLaporan', 'percPending',
            'chartData', 'chartLabels', 'lokasiData', 'laporanProduksi', 'topOperators', 'laporanPendingHariIni',
            'range', 'displayTotal', 'displayGrowth', 'displayCompareText', 'chartTitle', 'lokasi_id', 'daftarLokasi',
            'hariArray',
            'planData',
            'actualData',
            'achievementData',
            'bulan',
            'tahun',
            'tahunTersedia'
        ));
    }
}