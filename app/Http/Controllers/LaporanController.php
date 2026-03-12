<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProduksiHarian;
use App\Models\AlatTambang;
use App\Models\Hambatan;
use App\Models\Validasi;
use App\Models\AuditLog;
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
            'shift' => 'required',
            'lokasi' => 'required',
            'alat_tambang_id' => 'required',
            'volume' => 'required|numeric',
            'bahan_bakar' => 'required|numeric',
        ]);

        // 2. Simpan Data ke tabel produksi_harians
        $produksi = ProduksiHarian::create([
            'user_id' => auth()->id(),
            'alat_tambang_id' => $request->alat_tambang_id,
            'tanggal' => $request->tanggal,
            'shift' => $request->shift,
            'lokasi' => $request->lokasi,
            'volume' => $request->volume,
            'jarak_angkut' => $request->jarak, // sesuaikan name di HTML
            'jam_operasi' => $request->jam_operasi,
            'bahan_bakar' => $request->bahan_bakar,
            'cuaca' => $request->cuaca,
            'hambatan_operasional' => $request->hambatan,
            'catatan_tambahan' => $request->catatan,
            'status_laporan' => 'Pending',
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

        AuditLog::create([ 
            'user_id' => auth()->id(),
            'aksi'    => 'Menambah',
            'modul'   => 'Manajemen Laporan Harian',
            'detail'  => "Penambahan laporan baru:\nId: {$produksi->id} \nOperator:". auth()->user()->nama_lengkap,
        ]);

        // 4. Kembalikan ke halaman form dengan pesan sukses
        return redirect()->back()->with('success', 'Laporan Harian berhasil disimpan dan menunggu verifikasi Supervisor!');
    }

    public function verifikasi()
    {
        // Hanya ambil laporan yang statusnya masih 'Pending'
        $laporans = ProduksiHarian::with(['user', 'alatTambang'])
                    ->where('status_laporan', 'Pending')
                    ->orderBy('created_at', 'asc')
                    ->get();
                    
        return view('laporan.verifikasi', compact('laporans'));
    }

    // Memproses aksi Setujui / Tolak
    public function processVerifikasi(Request $request, $id)
    {
        $request->validate([
            'status_validasi' => 'required|in:Disetujui,Ditolak,Revisi',
            'catatan' => 'nullable|string'
        ]);

        // 1. Ubah status di tabel produksi_harians
        $laporan = ProduksiHarian::findOrFail($id);
        $laporan->update([
            'status_laporan' => $request->status_validasi
        ]);

        // 2. Catat rekam jejaknya di tabel validasis (Audit Trail)
        \App\Models\Validasi::create([
            'produksi_harian_id' => $laporan->id,
            'user_id' => Auth::id(), // ID Supervisor yang login
            'tanggal_validasi' => now(),
            'status_validasi' => $request->status_validasi,
            'catatan' => $request->catatan,
        ]);

        AuditLog::create([ 
            'user_id' => auth()->id(),
            'aksi'    => 'Verivikasi'. $request->status_validasi,
            'modul'   => 'Verifikasi Laporan Harian',
            'detail'  => "Verifikasi laporan harian:\nId: {$laporan->id} \nSupervisor: " . auth()->user()->nama_lengkap,
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diubah menjadi: ' . $request->status_validasi);
    }

    public function edit($id)
    {
        $laporan = ProduksiHarian::findOrFail($id);
        $alats = AlatTambang::all();
        
        // Keamanan: Jangan biarkan orang mengedit laporan yang sudah disetujui
        if($laporan->status_laporan != 'Pending') {
            return redirect()->back()->with('error', 'Laporan yang sudah diproses tidak bisa diedit!');
        }

        return view('laporan.edit', compact('laporan', 'alats'));
    }

    public function update(Request $request, $id)
    {
        $laporan = ProduksiHarian::findOrFail($id);
        
        // Validasi data (sama dengan store)
        $request->validate([
            'tanggal' => 'required|date',
            'volume' => 'required|numeric',
            // ... validasi lainnya ...
        ]);

        $laporan->update([
            'tanggal' => $request->tanggal,
            'shift' => $request->shift,
            'lokasi' => $request->lokasi,
            'alat_tambang_id' => $request->alat_tambang_id,
            'volume' => $request->volume,
            'jarak_angkut' => $request->jarak,
            'jam_operasi' => $request->jam_operasi,
            'bahan_bakar' => $request->bahan_bakar,
            'cuaca' => $request->cuaca,
            'hambatan_operasional' => $request->hambatan,
            'catatan_tambahan' => $request->catatan,
        ]);

        AuditLog::create([ 
            'user_id' => auth()->id(),
            'aksi'    => 'Memperbarui',
            'modul'   => 'Memperbarui Laporan Harian',
            'detail'  => "Memperbarui lokasi baru:\nId: {$laporan->id} \n   Operator:". auth()->user()->nama_lengkap,
        ]);

        return redirect()->route('laporan.riwayat')->with('success', 'Laporan Berhasil Diperbarui!');
    }
}