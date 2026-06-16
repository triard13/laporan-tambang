<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use App\Models\AuditLog;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Tangkap request pencarian dan jumlah per halaman (default 10)
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        // Query ke database User
        $query = User::query();

        // Jika ada pencarian
        if ($search) {
            $query->where('nama_lengkap', 'like', "%{$search}%") // Sesuaikan nama kolom dengan DB Anda (misal: 'name' atau 'nama_lengkap')
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
        }

        // Ambil data dengan pagination, lalu pertahankan query string di URL
        $users = $query->paginate($perPage)->appends($request->all());

        return view('users.index', compact('users', 'search', 'perPage'));
    }

    // Siapkan fungsi kosong untuk halaman lain agar tidak error jika tombol diklik
    public function create()
    {
        return view('users.create');
    }

    // 2. Memproses Simpan Data Pengguna Baru
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'nama_lengkap' => 'required|string|max:255', // Sesuaikan dengan kolom di DB (name / nama_lengkap)
            'email'        => 'required|email|unique:users,email',
            'nrp'          => 'nullable|string|unique:users,nrp',
            'nomor_hp'     => 'nullable|string',
            'password'     => 'required|string|min:6|confirmed', // Harus ada input password_confirmation
            'role'         => 'required|in:Admin,Supervisor,Operator',
            'jabatan'      => 'nullable|string',
            'status_karyawan' => 'required|in:Aktif,Non-Aktif',
        ], [
            // Pesan error custom bahasa Indonesia (Opsional)
            'email.unique'    => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Simpan ke database
        $pengguna = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'nrp'          => $request->nrp,
            'nomor_hp'     => $request->nomor_hp,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
            'jabatan'      => $request->jabatan,
            'status_karyawan' => $request->status_karyawan,
        ]);

        $pengguna->assignRole($request->role);

        AuditLog::create([ 
            'user_id' => auth()->id(),
            'aksi'    => 'Menambah',
            'modul'   => 'Manajemen Pengguna',
            'detail'  => "Penambahan pengguna baru:\nNama: {$pengguna->nama_lengkap} \nRole: {$pengguna->role}",
        ]);

        // Redirect kembali ke tabel dengan pesan sukses
        return redirect()->route('manajemen.users')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id); // Cari data user berdasarkan ID
        return view('users.edit', compact('user'));
    }

    // 4. Memproses Update Data Pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi inputan
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            // PENTING: Tambahkan pengecualian ID agar tidak error 'unique' ke diri sendiri
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'nrp'          => 'nullable|string|unique:users,nrp,' . $user->id,
            'nomor_hp'     => 'nullable|string',
            'password'     => 'nullable|string|min:6|confirmed', // Nullable = opsional
            'role'         => 'required|in:Admin,Supervisor,Operator',
            'jabatan'      => 'nullable|string',
            'status_karyawan' => 'required|in:Aktif,Non-Aktif',
        ], [
            'email.unique'    => 'Email ini sudah terdaftar di akun lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Siapkan data yang mau diupdate
        $dataUpdate = [
            'nama_lengkap' => $request->nama_lengkap,
            'email'        => $request->email,
            'nrp'          => $request->nrp,
            'nomor_hp'     => $request->nomor_hp,
            'role'         => $request->role,
            'jabatan'      => $request->jabatan,
            'status_karyawan' => $request->status_karyawan,
        ];

        // Jika form password diisi, berarti dia mau ganti password
        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        // Simpan perubahan ke database
        $user->update($dataUpdate);
        
        $user->syncRoles($request->role);

        AuditLog::create([ 
            'user_id' => auth()->id(),
            'aksi'    => 'Memperbarui',
            'modul'   => 'Manajemen Pengguna',
            'detail'  => "Memperbarui pengguna baru:\nNama: {$user->nama_lengkap} \nRole: {$user->role}",
        ]);

        return redirect()->route('manajemen.users')->with('success', 'Data pengguna berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // FITUR KEAMANAN: Cegah admin menghapus akunnya sendiri yang sedang dipakai login
        if ($user->id == auth()->id()) {
            return redirect()->route('manajemen.users')->with('error', 'Akses Ditolak: Anda tidak dapat menghapus akun Anda sendiri saat sedang login!');
        }

        // Hapus data dari database
        $user->delete();

        AuditLog::create([ 
            'user_id' => auth()->id(),
            'aksi'    => 'Menghapus',
            'modul'   => 'Manajemen Pengguna',
            'detail'  => "Menghapus pengguna baru:\nNama: {$user->nama_lengkap} \nRole: {$user->role}",
        ]);

        return redirect()->route('manajemen.users')->with('success', 'Pengguna bernama ' . $user->nama_lengkap . ' berhasil dihapus dari sistem!');
    }
}