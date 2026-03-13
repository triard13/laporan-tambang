<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Daftar modul untuk menyamakan urutan kolom di tabel UI
    private $moduls = ['dashboard', 'input', 'verifikasi', 'riwayat', 'pengguna', 'lokasi', 'alat'];

    public function index(Request $request)
    {
        $moduls = $this->moduls;

        // Mulai Query untuk Role
        $query = Role::query();

        // 1. Fitur Search (Cari berdasarkan nama Peran/Role)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Fitur Paginate (Diatur misal 10 data per halaman)
        $roles = $query->paginate(10)->appends($request->all());

        return view('rbac.index', compact('roles', 'moduls'));
    }

    public function edit($nama)
    {
        $role = Role::findByName($nama); // Ambil dari database!
        $moduls = $this->moduls;
        return view('rbac.edit', compact('role', 'moduls'));
    }

    public function update(Request $request, $nama)
    {
        $role = Role::findByName($nama);
        $permissionsToSync = [];

        if ($request->has('akses')) {
            $permissionsToSync = array_keys($request->akses);
        }

        $role->syncPermissions($permissionsToSync); // Simpan permanen ke DB!

        return redirect()->route('kontrol.akses')->with('success', "Hak akses untuk peran {$nama} berhasil diperbarui secara permanen!");
    }
}