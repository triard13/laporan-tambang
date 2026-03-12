<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlatTambang;
use Illuminate\Support\Facades\Storage;

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
            'kode_alat' => 'required|string|max:50|unique:alat_tambangs,kode_alat',
            'nama_alat' => 'required|string|max:255',
            'tipe_alat' => 'required|string|max:100',
            'kapasitas' => 'nullable|string|max:100',
            'jam_kerja' => 'required|integer|min:0',
            'status'    => 'required|in:Aktif,Perawatan,Rusak',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $data = $request->all();

        // Proses muat naik gambar jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('alat', 'public');
        }

        AlatTambang::create($data);

        return redirect()->route('manajemen.alat')->with('success', 'Data alat berat berjaya ditambah!');
    }

    // 4. Paparkan borang Edit
    public function edit($id)
    {
        $alat = AlatTambang::findOrFail($id);
        return view('alat.edit', compact('alat'));
    }

    // 5. Kemas kini data Alat
    public function update(Request $request, $id)
    {
        $alat = AlatTambang::findOrFail($id);

        $request->validate([
            'kode_alat' => 'required|string|max:50|unique:alat_tambangs,kode_alat,'.$alat->id,
            'nama_alat' => 'required|string|max:255',
            'tipe_alat' => 'required|string|max:100',
            'kapasitas' => 'nullable|string|max:100',
            'jam_kerja' => 'required|integer|min:0',
            'status'    => 'required|in:Aktif,Perawatan,Rusak',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Jika ada gambar baru dimuat naik
        if ($request->hasFile('gambar')) {
            // Padam gambar lama jika wujud
            if ($alat->gambar) {
                Storage::disk('public')->delete($alat->gambar);
            }
            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('alat', 'public');
        }

        $alat->update($data);

        return redirect()->route('manajemen.alat')->with('success', 'Data alat berat berjaya dikemas kini!');
    }

    // 6. Hapus data Alat
    public function destroy($id)
    {
        $alat = AlatTambang::findOrFail($id);
        
        // Padam gambar dari storage jika wujud
        if ($alat->gambar) {
            Storage::disk('public')->delete($alat->gambar);
        }

        $alat->delete();

        return redirect()->route('manajemen.alat')->with('success', 'Data alat berat berjaya dipadam!');
    }
}