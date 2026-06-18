<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProduksiHarian;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalisisController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $queryProduksi = ProduksiHarian::where('status_laporan', 'Disetujui')
                            ->whereMonth('tanggal', $bulan)
                            ->whereYear('tanggal', $tahun);

        // 1. Kinerja Operator (Volume Terbanyak)
        $kinerjaOperator = (clone $queryProduksi)
            ->with('user')
            ->select('user_id', DB::raw('SUM(volume) as total_volume'))
            ->groupBy('user_id')
            ->orderByDesc('total_volume')
            ->take(10)
            ->get()
            ->map(function($item) {
                return [
                    'nama_operator' => $item->user->nama_lengkap ?? 'Unknown',
                    'total_volume' => $item->total_volume,
                ];
            });

        // 2. Efisiensi Penggunaan Alat (Bahan Bakar per Volume)
        $efisiensiAlat = (clone $queryProduksi)
            ->with('alatTambang')
            ->select('alat_tambang_id', 
                     DB::raw('SUM(volume) as total_volume'), 
                     DB::raw('SUM(bahan_bakar) as total_bbm'))
            ->groupBy('alat_tambang_id')
            ->having('total_volume', '>', 0) // Avoid division by zero
            ->get()
            ->map(function($item) {
                $rasio = round($item->total_bbm / $item->total_volume, 2);
                $status = 'Normal';
                
                // Asumsi: jika rasio > 1.2 Liter/BCM, maka boros/perlu pengecekan
                if ($rasio > 1.2) {
                    $status = 'Boros / Perlu Cek';
                } elseif ($rasio < 0.7) {
                    $status = 'Sangat Efisien';
                }

                return [
                    'nama_alat' => $item->alatTambang->nama_alat ?? 'Unknown',
                    'total_volume' => $item->total_volume,
                    'total_bbm' => $item->total_bbm,
                    'rasio' => $rasio,
                    'status' => $status
                ];
            })
            ->sortByDesc('rasio')
            ->values();

        // 3. Pemetaan Hambatan Operasional (Dari tabel hambatans yang join ke produksi)
        $statistikHambatan = DB::table('hambatans')
            ->join('produksi_harians', 'hambatans.produksi_harian_id', '=', 'produksi_harians.id')
            ->where('produksi_harians.status_laporan', 'Disetujui')
            ->whereMonth('produksi_harians.tanggal', $bulan)
            ->whereYear('produksi_harians.tanggal', $tahun)
            ->select('hambatans.jenis_hambatan', DB::raw('count(*) as total'))
            ->groupBy('hambatans.jenis_hambatan')
            ->orderByDesc('total')
            ->get();

        // Pemetaan Cuaca
        $statistikCuaca = (clone $queryProduksi)
            ->select('cuaca', DB::raw('count(*) as total'))
            ->groupBy('cuaca')
            ->orderByDesc('total')
            ->get();

        return view('analisis.index', compact(
            'kinerjaOperator', 
            'efisiensiAlat', 
            'statistikHambatan', 
            'statistikCuaca',
            'bulan',
            'tahun'
        ));
    }
}
