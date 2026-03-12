<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlatTambangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login'); // Langsung arahkan ke halaman login
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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

    Route::post('/verifikasi-laporan/{id}', [LaporanController::class, 'processVerifikasi'])->name('laporan.process_verifikasi');
});

// 3. Rute Khusus Admin -> Manajemen Master Data
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/manajemen-pengguna', [UserController::class, 'index'])->name('manajemen.users');
    Route::get('/manajemen-pengguna/tambah', [UserController::class, 'create'])->name('users.create');
    Route::post('/manajemen-pengguna', [UserController::class, 'store'])->name('users.store');
    Route::get('/manajemen-pengguna/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/manajemen-pengguna/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/manajemen-pengguna/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('alat', AlatTambangController::class)->names([
        'index' => 'manajemen.alat',
    ]);
    Route::get('/manajemen-lokasi', function () { return "Halaman Manajemen Lokasi"; })->name('manajemen.lokasi');
});

// Rute Riwayat Laporan (Bisa diakses semua role yang login)
Route::middleware(['auth'])->group(function () {
    Route::get('/riwayat-laporan', [LaporanController::class, 'index'])->name('laporan.riwayat');
    Route::get('/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
});

require __DIR__.'/auth.php';