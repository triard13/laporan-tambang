<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ProduksiHarian;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with('pendingVerificationCount', ProduksiHarian::where('status_laporan', 'Pending')->count());
            $view->with('riwayatLaporanCount', ProduksiHarian::count());
            $view->with('usersCount', User::count());
        });
    }
}
