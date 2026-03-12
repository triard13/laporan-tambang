<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;
use App\Models\User; // Pastikan ini dipanggil

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        // 1. Filter Aksi
        if ($request->filled('aksi') && $request->aksi != 'Semua Aksi') {
            $query->where('aksi', $request->aksi);
        }

        // 2. Filter Pengguna
        if ($request->filled('user_id') && $request->user_id != 'Semua Pengguna') {
            $query->where('user_id', $request->user_id);
        }

        // 3. Filter Rentang Tanggal (Start Date - End Date)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00', 
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Eksekusi dengan pagination, dan pertahankan parameter URL (appends)
        $logs = $query->paginate(10)->appends($request->all());
        
        // Ambil data user untuk opsi di dropdown
        $users = User::orderBy('nama_lengkap', 'asc')->get();

        return view('log-aktifitas.index', compact('logs', 'users'));
    }
}