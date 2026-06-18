<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlatTambangController;
use App\Http\Controllers\LokasiTambangController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return redirect()->route('login'); // Langsung arahkan ke halaman login
});

Route::get('/link-storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Storage berhasil disambung, Ndan!';
});

Route::get('/bersihkan-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache berhasil disapu bersih, Ndan!';
});

// ==========================================
// RUTE PROFIL UMUM (Bisa diakses semua yang login)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// RUTE SISTEM LAPORAN TAMBANG (DILINDUNGI RBAC SPATIE)
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('can:dashboard')
        ->name('dashboard');

    Route::get('/analisis', [AnalisisController::class, 'index'])
        ->middleware('can:dashboard')
        ->name('analisis.index');

    // 2. Modul Data Laporan (Input, Verifikasi, Riwayat)
    Route::middleware('can:input')->group(function () {
        Route::get('/input-laporan', [LaporanController::class, 'create'])->name('laporan.create');
        Route::post('/input-laporan', [LaporanController::class, 'store'])->name('laporan.store');
    });

    Route::middleware('can:verifikasi')->group(function () {
        Route::get('/verifikasi-laporan', [LaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
        Route::post('/verifikasi-laporan/{id}', [LaporanController::class, 'processVerifikasi'])->name('laporan.process_verifikasi');
    });

    Route::middleware('can:riwayat')->group(function () {
        Route::get('/riwayat-laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
        Route::get('/riwayat-laporan', [LaporanController::class, 'index'])->name('laporan.riwayat');
        Route::get('/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
        Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
    });

    // 3. Modul Manajemen (Pengguna, Alat, Lokasi)
    Route::middleware('can:pengguna')->group(function () {
        Route::get('/manajemen-pengguna', [UserController::class, 'index'])->name('manajemen.users');
        Route::get('/manajemen-pengguna/tambah', [UserController::class, 'create'])->name('users.create');
        Route::post('/manajemen-pengguna', [UserController::class, 'store'])->name('users.store');
        Route::get('/manajemen-pengguna/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/manajemen-pengguna/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/manajemen-pengguna/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware('can:alat')->group(function () {
        Route::resource('alat', AlatTambangController::class)->names([
            'index' => 'manajemen.alat',
        ]);
    });

    Route::middleware('can:lokasi')->group(function () {
        Route::resource('lokasi', LokasiTambangController::class)->names([
            'index' => 'manajemen.lokasi',
        ]);
    });

    // ==========================================
    // RUTE KHUSUS SUPER ADMIN
    // ==========================================
    Route::middleware('role:Admin')->group(function () {
        // Log Aktifitas
        Route::get('/log-aktifitas', [AuditLogController::class, 'index'])->name('log.aktifitas');
        
        // Kontrol Akses (RBAC)
        Route::get('/kontrol-akses', [RoleController::class, 'index'])->name('kontrol.akses');
        Route::get('/kontrol-akses/{nama}/edit', [RoleController::class, 'edit'])->name('kontrol.edit');
        Route::put('/kontrol-akses/{nama}', [RoleController::class, 'update'])->name('kontrol.update');
    });

});

require __DIR__.'/auth.php';    