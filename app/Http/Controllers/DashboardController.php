<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProduksiHarian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // --- DATA PERIODE SEKARANG (Minggu Ini) ---
        $startOfCurrentWeek = now()->startOfWeek();
        $endOfCurrentWeek = now()->endOfWeek();

        $range = $request->get('range', 7);
        $startDate = now()->subDays($range - 1)->startOfDay();

        $totalProduksi = ProduksiHarian::where('status_laporan', 'Disetujui')->sum('volume');
        $prodMingguIni = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfCurrentWeek, $endOfCurrentWeek])
            ->sum('volume');
        
        $totalProduksiHariIni = ProduksiHarian::where('status_laporan', 'Disetujui')
        ->whereDate('tanggal', now())
        ->sum('volume');

        $laporanDisetujui = ProduksiHarian::where('status_laporan', 'Disetujui')->count();
        $laporanDisetujuiMingguIni = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfCurrentWeek, $endOfCurrentWeek])
            ->count();

        $laporanPending = ProduksiHarian::where('status_laporan', 'Pending')->count();
        $laporanDitolak = ProduksiHarian::where('status_laporan', 'Ditolak')->count();

        // --- DATA PERIODE LALU (Minggu Lalu) ---
        $startOfLastWeek = now()->subWeek()->startOfWeek();
        $endOfLastWeek = now()->subWeek()->endOfWeek();

        $prodMingguLalu = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfLastWeek, $endOfLastWeek])
            ->sum('volume');

        $laporanDisetujuiMingguLalu = ProduksiHarian::where('status_laporan', 'Disetujui')
            ->whereBetween('tanggal', [$startOfLastWeek, $endOfLastWeek])
            ->count();

        // --- HITUNG PERSENTASE AKTUAL ---
        // Rumus: ((Sekarang - Lalu) / Lalu) * 100
        $growthProduksi = $prodMingguLalu > 0 ? (($prodMingguIni - $prodMingguLalu) / $prodMingguLalu) * 100 : 0;
        $growthLaporan = $laporanDisetujuiMingguLalu > 0 ? (($laporanDisetujuiMingguIni - $laporanDisetujuiMingguLalu) / $laporanDisetujuiMingguLalu) * 100 : 0;

        // Persentase laporan pending terhadap total (opsional)
        $totalLaporanMasuk = ProduksiHarian::count();
        $percPending = $totalLaporanMasuk > 0 ? ($laporanPending / $totalLaporanMasuk) * 100 : 0;

        // (Data grafik tetap sama seperti sebelumnya)
        $chartData = ProduksiHarian::select(DB::raw('DATE(tanggal) as date'), DB::raw('SUM(volume) as total'))
            ->where('status_laporan', 'Disetujui')
            ->where('tanggal', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $lokasiData = ProduksiHarian::select('lokasi', DB::raw('SUM(volume) as total'))
            ->where('status_laporan', 'Disetujui')
            ->groupBy('lokasi')->get();

        // Ambil data untuk tabel kiri dengan Pagination (misal 3 data per halaman)
        // Kita beri nama query string 'page_laporan' agar tidak bentrok dengan pagination lain
        // Ambil data untuk tabel kiri (hanya untuk hari ini) dengan Pagination
        $laporanProduksi = ProduksiHarian::with(['user', 'alatTambang'])
            ->where('status_laporan', 'Disetujui')
            ->whereDate('tanggal', \Carbon\Carbon::today()) // Tambahkan filter ini
            ->orderBy('created_at', 'desc')
            ->paginate(3, ['*'], 'page_laporan');

        // Data untuk tabel kanan (Laporan Terakhir) tetap ambil 5 saja tanpa pagination
        $laporanTerakhir = ProduksiHarian::with(['user', 'alatTambang'])
            ->orderBy('created_at', 'desc')
            ->paginate(4, ['*'], 'page_akhir') // Ambil 4 data per halaman
            ->withQueryString();

        return view('dashboard', compact(
            'totalProduksi', 'totalProduksiHariIni', 'laporanDisetujui', 'laporanPending', 'laporanDitolak', 
            'growthProduksi', 'growthLaporan', 'percPending',
            'chartData', 'lokasiData', 'laporanProduksi', 'laporanTerakhir', 'range'
        ));
    }
}