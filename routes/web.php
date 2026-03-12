<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login'); // Langsung arahkan ke halaman login
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// RUTE KHUSUS SISTEM LAPORAN TAMBANG
// ==========================================

// 1. Rute untuk Operator (dan Supervisor) -> Mengelola Input Laporan
Route::middleware(['auth', 'role:Operator,Supervisor'])->group(function () {
    Route::get('/input-laporan', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/input-laporan', [LaporanController::class, 'store'])->name('laporan.store');
});

// 2. Rute Khusus Supervisor -> Verifikasi Laporan
Route::middleware(['auth', 'role:Supervisor'])->group(function () {
    Route::get('/verifikasi-laporan', [LaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
    // Nanti ditambah rute post/patch untuk aksi setujui/tolak
});

// 3. Rute Khusus Admin -> Manajemen Master Data
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/manajemen-pengguna', function () { return "Halaman Manajemen Pengguna"; })->name('manajemen.users');
    Route::get('/manajemen-alat', function () { return "Halaman Manajemen Alat"; })->name('manajemen.alat');
    Route::get('/manajemen-lokasi', function () { return "Halaman Manajemen Lokasi"; })->name('manajemen.lokasi');
});

// Rute Riwayat Laporan (Bisa diakses semua role yang login)
Route::middleware(['auth'])->group(function () {
    Route::get('/riwayat-laporan', [LaporanController::class, 'index'])->name('laporan.riwayat');
});

require __DIR__.'/auth.php';