<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val)); if(darkMode) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark')"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Laporan Tambang') }}</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📊</text></svg>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f3f4f6] dark:bg-[#09090b] transition-colors duration-200" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" @click="sidebarOpen = false" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-[260px] bg-[#fdfdfd] dark:bg-[#0f0f11] border-r border-gray-100 dark:border-[#27272a] flex flex-col transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
            
            <!-- Logo Area -->
            <div class="h-24 flex items-center px-6 pt-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#18181b] dark:bg-white rounded-xl flex items-center justify-center text-white dark:text-[#18181b] shadow-md transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-[16px] text-gray-900 dark:text-white leading-tight flex items-center gap-1 transition-colors duration-200">
                            Laporan Tambang
                        </h1>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500 font-medium flex items-center gap-1 transition-colors duration-200">
                            Sistem Internal
                        </p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-8 overflow-y-auto custom-scrollbar">
                
                <!-- MENU SECTION -->
                <div>
                    <h3 class="px-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Menu</h3>
                    <div class="space-y-1">
                        @can('dashboard')
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] shadow-xl shadow-black/10 dark:shadow-white/5' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white dark:text-[#18181b]' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                <span class="text-[14px] font-semibold">Dashboard</span>
                            </a>
                            
                            <a href="{{ route('analisis.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('analisis.index') ? 'bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] shadow-xl shadow-black/10 dark:shadow-white/5' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('analisis.index') ? 'text-white dark:text-[#18181b]' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                <span class="text-[14px] font-semibold flex-1">Analisis Data</span>
                            </a>
                        @endcan
                        
                        @can('input')
                            <a href="{{ route('laporan.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('laporan.create') ? 'bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] shadow-xl shadow-black/10 dark:shadow-white/5' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('laporan.create') ? 'text-white dark:text-[#18181b]' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <span class="text-[14px] font-semibold flex-1">Input Laporan</span>
                            </a>
                        @endcan

                        @can('verifikasi')
                            <a href="{{ route('laporan.verifikasi') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('laporan.verifikasi') ? 'bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] shadow-xl shadow-black/10 dark:shadow-white/5' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('laporan.verifikasi') ? 'text-white dark:text-[#18181b]' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-[14px] font-semibold flex-1">Verifikasi Laporan</span>
                                @if($pendingVerificationCount > 0)
                                    <span class="bg-[#f27b53] text-white dark:text-[#18181b] text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingVerificationCount }}</span>
                                @endif
                            </a>
                        @endcan

                        @can('riwayat')
                            <a href="{{ route('laporan.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('laporan.riwayat') ? 'bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] shadow-xl shadow-black/10 dark:shadow-white/5' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('laporan.riwayat') ? 'text-white dark:text-[#18181b]' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-[14px] font-semibold flex-1">Riwayat Laporan</span>
                                @if($riwayatLaporanCount > 0)
                                    <span class="bg-[#f27b53] text-white dark:text-[#18181b] text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $riwayatLaporanCount }}</span>
                                @endif
                            </a>
                        @endcan
                    </div>
                </div>

                <!-- OTHERS SECTION -->
                <div>
                    <h3 class="px-4 text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Others</h3>
                    <div class="space-y-1">
                        @can('pengguna')
                            <a href="{{ route('manajemen.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('manajemen.users') ? 'bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] shadow-xl shadow-black/10 dark:shadow-white/5' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('manajemen.users') ? 'text-white dark:text-[#18181b]' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span class="text-[14px] font-semibold flex-1">Manajemen Pengguna</span>
                                @if($usersCount > 0)
                                    <span class="bg-[#f27b53] text-white dark:text-[#18181b] text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $usersCount }}</span>
                                @endif
                            </a>
                        @endcan
                        
                        @can('alat')
                            <a href="{{ route('manajemen.alat') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('manajemen.alat') ? 'bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] shadow-xl shadow-black/10 dark:shadow-white/5' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('manajemen.alat') ? 'text-white dark:text-[#18181b]' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-[14px] font-semibold">Alat Berat</span>
                            </a>
                        @endcan
                        
                        @can('lokasi')
                            <a href="{{ route('manajemen.lokasi') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('manajemen.lokasi') ? 'bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] shadow-xl shadow-black/10 dark:shadow-white/5' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('manajemen.lokasi') ? 'text-white dark:text-[#18181b]' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-[14px] font-semibold">Lokasi Tambang</span>
                            </a>
                        @endcan

                        @role('Admin')
                            <a href="{{ route('log.aktifitas') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('log.aktifitas') ? 'bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] shadow-xl shadow-black/10 dark:shadow-white/5' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('log.aktifitas') ? 'text-white dark:text-[#18181b]' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <span class="text-[14px] font-semibold">Log Aktifitas</span>
                            </a>
                            <a href="{{ route('kontrol.akses') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->routeIs('kontrol.akses', 'kontrol.*') ? 'bg-[#18181b] dark:bg-white text-white dark:text-[#18181b] shadow-xl shadow-black/10 dark:shadow-white/5' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                                <svg class="w-5 h-5 {{ request()->routeIs('kontrol.akses') ? 'text-white dark:text-[#18181b]' : 'text-gray-400 dark:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <span class="text-[14px] font-semibold">Manajemen Akses</span>
                            </a>
                        @endrole
                    </div>
                </div>

            </nav>

            <!-- User Profile Bottom -->
            <div class="p-4 mt-auto border-t border-gray-100 dark:border-[#27272a]">

                
                <div class="flex items-center gap-3 mt-4 px-2">
                    <img class="w-10 h-10 rounded-full border border-gray-200 dark:border-[#27272a] object-cover" 
                         src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->nama_lengkap).'&background=random&color=fff' }}" 
                         alt="Avatar">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->nama_lengkap }}</p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden w-full bg-[#f3f4f6] dark:bg-[#09090b] transition-colors duration-200">
            
            <!-- Header -->
            <header class="h-20 lg:h-24 bg-transparent flex items-center justify-between px-4 lg:px-8 mt-2">
                
                <!-- Mobile toggle -->
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden mr-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Search Bar -->
                <div class="flex-1 max-w-xl">
                    <form action="{{ route('laporan.riwayat') }}" method="GET" class="relative flex items-center" x-data x-on:keydown.window.prevent.cmd.s="$refs.searchInput.focus()" x-on:keydown.window.prevent.ctrl.s="$refs.searchInput.focus()">
                        <svg class="absolute left-4 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input x-ref="searchInput" type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan..." class="w-full bg-white dark:bg-[#18181b] border-0 rounded-full py-3 pl-12 pr-12 text-sm text-gray-700 dark:text-white shadow-sm focus:ring-2 focus:ring-[#18181b] dark:focus:ring-white/20 placeholder-gray-400 dark:placeholder-gray-500 font-medium transition-colors">
                        <div class="absolute right-4 text-xs font-bold text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-white/5 px-2 py-1 rounded transition-colors">⌘S</div>
                    </form>
                </div>

                <!-- Right Header Actions -->
                <div class="flex items-center gap-3 lg:gap-5 ml-auto pl-4">

                    <!-- Theme Toggle -->
                    <div class="bg-white rounded-full p-1 flex shadow-sm border border-gray-100 transition-colors dark:bg-gray-800 dark:border-gray-700">
                        <button @click="darkMode = false; document.documentElement.classList.remove('dark')" :class="!darkMode ? 'bg-[#18181b] text-white' : 'text-gray-400 hover:text-gray-600'" class="w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path></svg>
                        </button>
                        <button @click="darkMode = true; document.documentElement.classList.add('dark')" :class="darkMode ? 'bg-[#18181b] text-white' : 'text-gray-400 hover:text-gray-600'" class="w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        </button>
                    </div>

                    <!-- Notification -->
                    @php
                        $notifikasiPending = \App\Models\ProduksiHarian::with('lokasiTambang')
                            ->where('status_laporan', 'Pending')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                        $jumlahNotifikasi = \App\Models\ProduksiHarian::where('status_laporan', 'Pending')->count();
                    @endphp
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" class="w-10 h-10 bg-white dark:bg-[#18181b] rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 shadow-sm hover:shadow dark:hover:bg-white/5 transition relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @if($jumlahNotifikasi > 0)
                                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-[#18181b]"></span>
                            @endif
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div x-show="open" style="display: none;" class="absolute right-0 mt-2 w-80 bg-white dark:bg-[#18181b] rounded-2xl shadow-lg border border-gray-100 dark:border-[#27272a] py-2 z-50 overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-100 dark:border-[#27272a] flex justify-between items-center">
                                <span class="font-bold text-sm text-gray-900 dark:text-white">Notifikasi</span>
                                @if($jumlahNotifikasi > 0)
                                    <span class="text-[10px] bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400 px-2 py-0.5 rounded-full font-bold">{{ $jumlahNotifikasi > 99 ? '99+' : $jumlahNotifikasi }} Baru</span>
                                @endif
                            </div>
                            <div class="max-h-64 overflow-y-auto custom-scrollbar">
                                @forelse($notifikasiPending as $notif)
                                    <a href="{{ route('laporan.verifikasi') }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-white/5 transition">
                                        <p class="text-sm text-gray-800 dark:text-gray-200 font-bold">Laporan baru masuk</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Laporan harian {{ $notif->lokasiTambang->nama_lokasi ?? 'Lokasi' }} menunggu verifikasi Anda.</p>
                                        <p class="text-[10px] text-gray-400 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi baru.</p>
                                    </div>
                                @endforelse
                            </div>
                            <a href="{{ route('laporan.verifikasi') }}" class="block px-4 py-2 text-center text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:bg-gray-50 dark:hover:bg-white/5 border-t border-gray-100 dark:border-[#27272a]">
                                Lihat Semua
                            </a>
                        </div>
                    </div>

                    <!-- Logout -->
                    <div x-data="{ showLogoutModal: false }">
                        <button type="button" @click="showLogoutModal = true" title="Logout" class="w-10 h-10 bg-white dark:bg-[#18181b] rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 shadow-sm hover:shadow hover:text-red-500 dark:hover:text-red-400 dark:hover:bg-white/5 transition relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>

                        <!-- Logout Confirmation Modal -->
                        <div x-show="showLogoutModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <!-- Background overlay -->
                                <div x-show="showLogoutModal" 
                                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                                     class="fixed inset-0 bg-gray-900 bg-opacity-50 dark:bg-opacity-80 transition-opacity" @click="showLogoutModal = false" aria-hidden="true"></div>

                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                <!-- Modal panel -->
                                <div x-show="showLogoutModal" 
                                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                     class="inline-block align-bottom bg-white dark:bg-[#18181b] rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm w-full border border-gray-100 dark:border-[#27272a]">
                                    
                                    <div class="bg-white dark:bg-[#18181b] px-4 pt-5 pb-4 sm:p-6 sm:pb-4 text-center">
                                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-500/20 mb-5">
                                            <svg class="h-8 w-8 text-red-600 dark:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl leading-6 font-extrabold text-gray-900 dark:text-white" id="modal-title">
                                            Konfirmasi Keluar
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Apakah Anda yakin ingin keluar dari aplikasi?
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gray-50 dark:bg-[#27272a]/30 px-4 py-4 sm:px-6 flex flex-col-reverse sm:flex-row gap-3 sm:gap-4 justify-center">
                                        <button type="button" @click="showLogoutModal = false" class="w-full sm:w-auto inline-flex justify-center rounded-full border border-gray-300 dark:border-gray-600 shadow-sm px-6 py-2.5 bg-white dark:bg-transparent text-base font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm transition-colors">
                                            Batal
                                        </button>
                                        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto m-0">
                                            @csrf
                                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-full border border-transparent shadow-sm px-6 py-2.5 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm transition-colors">
                                                Ya, Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto px-4 lg:px-8 pb-12">
                {{ $slot }}
            </main>
        </div>

    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
    @stack('scripts')
</body>
</html>