<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProduksiHarian;
use App\Models\AlatTambang;
use App\Models\Hambatan;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // Menampilkan halaman riwayat laporan
    public function index()
    {
        $laporans = ProduksiHarian::with(['user', 'alatTambang'])->orderBy('created_at', 'desc')->get();
        
        return view('laporan.index', compact('laporans'));
    }

    // Menampilkan form input laporan harian
    public function create()
    {
        // Mengambil semua data alat tambang dari database untuk ditampilkan di dropdown
        $alatTambang = AlatTambang::all();
        
        return view('laporan.create', compact('alatTambang'));
    }

    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $request->validate([
            'tanggal' => 'required|date',
            'alat_tambang_id' => 'required',
            'material' => 'required|string',
            'volume' => 'required|numeric',
            'jam_operasi' => 'required|integer',
            'lokasi' => 'required|string',
            'bahan_bakar' => 'required|numeric',
        ]);

        // 2. Simpan Data ke tabel produksi_harians
        $produksi = ProduksiHarian::create([
            'user_id' => Auth::id(), // ID Operator yang sedang login
            'alat_tambang_id' => $request->alat_tambang_id,
            'tanggal' => $request->tanggal,
            'material' => $request->material,
            'volume' => $request->volume,
            'jam_operasi' => $request->jam_operasi,
            'lokasi' => $request->lokasi,
            'bahan_bakar' => $request->bahan_bakar,
            'status_laporan' => 'Pending', // Status awal sesuai rancangan
        ]);

        // 3. Jika operator mengisi form Hambatan, simpan ke tabel hambatans
        if ($request->filled('jenis_hambatan') && $request->jenis_hambatan != '') {
            Hambatan::create([
                'produksi_harian_id' => $produksi->id, // Relasi ke ID produksi yang baru dibuat
                'jenis_hambatan' => $request->jenis_hambatan,
                'durasi' => 0, // Default 0 jika tidak ada input khusus durasi
                'keterangan' => $request->keterangan,
            ]);
        }

        // 4. Kembalikan ke halaman form dengan pesan sukses
        return redirect()->back()->with('success', 'Laporan Harian berhasil disimpan dan menunggu verifikasi Supervisor!');
    }

    // Menampilkan halaman verifikasi (Khusus Supervisor)
    public function verifikasi()
    {
        return view('laporan.verifikasi'); // Nanti kita buat file ini
    }
}