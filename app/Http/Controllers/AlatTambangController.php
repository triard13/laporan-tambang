<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlatTambang;
use Illuminate\Support\Facades\Storage;
use App\Models\AuditLog;

class AlatTambangController extends Controller
{
    public function index()
    {
        $alats = AlatTambang::paginate(10);
        return view('alat.index', compact('alats'));
    }

    public function create()
    {
        return view('alat.create');
    }

    // 3. Simpan data Alat Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'tipe_alat' => 'required|string|max:100',
            'kapasitas' => 'nullable|string|max:100',
            'jam_kerja' => 'required|integer|min:0',
            'status'    => 'required|in:Aktif,Perawatan,Rusak',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $data = $request->all();

        // Generate Kode Alat Otomatis
        $prefix = 'ALT';
        if ($data['tipe_alat'] == 'Dump Truck') {
            $prefix = 'DT';
        } elseif ($data['tipe_alat'] == 'Excavator') {
            $prefix = 'EXC';
        } elseif ($data['tipe_alat'] == 'Dozer') {
            $prefix = 'DZ';
        } elseif ($data['tipe_alat'] == 'Grader') {
            $prefix = 'GRD';
        }

        $lastAlat = AlatTambang::where('kode_alat', 'like', $prefix . '-%')
                               ->orderBy('id', 'desc')->first();
        
        if ($lastAlat) {
            // Ambil angka terakhir setelah prefix dan strip
            $lastNumber = (int) substr($lastAlat->kode_alat, strlen($prefix) + 1);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $data['kode_alat'] = $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Proses upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('alat', 'public');
        }

        $alat = AlatTambang::create($data);
        AuditLog::create([
            'user_id' => auth()->id(),
            'aksi'    => 'Menambah',
            'modul'   => 'Manajemen Alat',
            'detail'  => "Penambahan alat baru:\nKode: {$alat->kode_alat} \nNama: {$alat->nama_alat}",
        ]);

        return redirect()->route('manajemen.alat')->with('success', 'Data alat berat berhasil ditambahkan!');
    }

    // 4. Tampilkan formulir Edit
    public function edit($id)
    {
        $alat = AlatTambang::findOrFail($id);
        return view('alat.edit', compact('alat'));
    }

    // 5. Perbarui data Alat
    public function update(Request $request, $id)
    {
        $alat = AlatTambang::findOrFail($id);

        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'tipe_alat' => 'required|string|max:100',
            'kapasitas' => 'nullable|string|max:100',
            'jam_kerja' => 'required|integer|min:0',
            'status'    => 'required|in:Aktif,Perawatan,Rusak',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        unset($data['kode_alat']); // Jangan biarkan kode_alat diupdate

        // Jika ada gambar baru diupload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($alat->gambar) {
                Storage::disk('public')->delete($alat->gambar);
            }
            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('alat', 'public');
        }

        $alat->update($data);

        AuditLog::create([
            'user_id' => auth()->id(),
            'aksi'    => 'Memperbarui',
            'modul'   => 'Manajemen Alat',
            'detail'  => "Memperbarui alat:\nKode: {$alat->kode_alat} \nNama: {$alat->nama_alat}",
        ]);

        return redirect()->route('manajemen.alat')->with('success', 'Data alat berat berhasil diperbarui!');
    }

    // 6. Hapus data Alat
    public function destroy($id)
    {
        $alat = AlatTambang::findOrFail($id);
        
        // Hapus gambar dari storage jika ada
        if ($alat->gambar) {
            Storage::disk('public')->delete($alat->gambar);
        }

        $alat->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'aksi'    => 'Menghapus',
            'modul'   => 'Manajemen Alat',
            'detail'  => "Menghapus alat:\nKode: {$alat->kode_alat} \nNama: {$alat->nama_alat}",
        ]);

        return redirect()->route('manajemen.alat')->with('success', 'Data alat berat berhasil dihapus!');
    }
}