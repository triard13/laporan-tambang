<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiTambang;
use App\Models\User;
use App\Models\AuditLog;

class LokasiTambangController extends Controller
{
    public function index()
    {
        $lokasis = LokasiTambang::paginate(10);
        return view('lokasi.index', compact('lokasis'));
    }

    public function create()
    {
        $users = User::all();
        return view('lokasi.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'koordinat'   => 'nullable|string|max:255',
            'luas_area'   => 'nullable|integer',
            'koordinator' => 'nullable|string|max:255',
        ]);

        $lokasi = LokasiTambang::create($request->all());
        AuditLog::create([ 
            'user_id' => auth()->id(),
            'aksi'    => 'Menambah',
            'modul'   => 'Manajemen Lokasi \n{$lokasi->nama_lokasi}',
            'detail'  => "Penambahan lokasi baru:\nNama: {$lokasi->nama_lokasi} \nKoordinator: {$lokasi->koordinator}",
        ]);
        return redirect()->route('manajemen.lokasi')->with('success', 'Lokasi tambang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $lokasi = LokasiTambang::findOrFail($id);
        $users = User::all();
        return view('lokasi.edit', compact('lokasi', 'users'));
    }

    public function update(Request $request, $id)
    {
        $lokasi = LokasiTambang::findOrFail($id);
        
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'koordinat'   => 'nullable|string|max:255',
            'luas_area'   => 'nullable|integer',
            'koordinator' => 'nullable|string|max:255',
        ]);

        $lokasi->update($request->all());
        AuditLog::create([
            'user_id' => auth()->id(),
            'aksi'    => 'Memperbarui',
            'modul'   => 'Manajemen Lokasi \n{$lokasi->nama_lokasi}',
            'detail'  => "Memperbarui lokasi:\nNama: {$lokasi->nama_lokasi} \nKoordinator: {$lokasi->koordinator}",
        ]);
        return redirect()->route('manajemen.lokasi')->with('success', 'Data lokasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lokasi = LokasiTambang::findOrFail($id);
        $lokasi->delete();
        AuditLog::create([
            'user_id' => auth()->id(),
            'aksi'    => 'Menghapus',
            'modul'   => 'Manajemen Lokasi {$lokasi->nama_lokasi}',
            'detail'  => "Menghapus lokasi:\nNama: {$lokasi->nama_lokasi} \nKoordinator: {$lokasi->koordinator}",
        ]);
        return redirect()->route('manajemen.lokasi')->with('success', 'Lokasi tambang berhasil dihapus!');
    }
}
