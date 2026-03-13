<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistem Laporan Tambang') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen overflow-hidden">
            
            <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" @click="sidebarOpen = false" style="display: none;"></div>

            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-[#2b2b36] text-white flex flex-col shadow-lg transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
                
                <div class="h-16 flex items-center justify-between px-4 border-b border-gray-700 mt-4 pb-4">
                    <div class="text-xl font-bold flex items-center gap-2 w-full justify-center">
                        <span>📊 Laporan Tambang</span>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto text-sm font-medium">
                    
                    @can('dashboard')
                        <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Dashboard</a>
                    @endcan
                    
                    @can('input')
                        <a href="{{ route('laporan.create') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('laporan.create') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Input Laporan</a>
                    @endcan

                    @can('verifikasi')
                        <a href="{{ route('laporan.verifikasi') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('laporan.verifikasi') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Verifikasi Laporan</a>
                    @endcan

                    @can('riwayat')
                        <a href="{{ route('laporan.riwayat') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('laporan.riwayat') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Riwayat Laporan</a>
                    @endcan
                    
                    @can('pengguna')
                        <a href="{{ route('manajemen.users') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('manajemen.users') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Manajemen Pengguna</a>
                    @endcan
                    
                    @can('alat')
                        <a href="{{ route('manajemen.alat') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('manajemen.alat') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Manajemen Alat</a>
                    @endcan
                    
                    @can('lokasi')
                        <a href="{{ route('manajemen.lokasi') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('manajemen.lokasi') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Manajemen Lokasi</a>
                    @endcan

                    @role('Admin')
                        <a href="{{ route('log.aktifitas') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('log.aktifitas') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Log Aktifitas</a>
                        <a href="{{ route('kontrol.akses') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('kontrol.akses', 'kontrol.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Manajemen Akses</a>
                    @endrole
                </nav>
            </aside>

            <div class="flex-1 flex flex-col overflow-hidden w-full">
                
                <header class="h-16 bg-white border-b flex items-center justify-between lg:justify-end px-4 lg:px-6 shadow-sm">
                    
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-2 focus:outline-none hover:bg-gray-50 p-1.5 rounded-md transition">
                            <img class="w-8 h-8 rounded-full border border-gray-200 object-cover" 
                                 src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->nama_lengkap).'&background=random&color=fff' }}" 
                                 alt="Avatar">
                            
                            <span class="text-sm font-bold text-gray-700 hidden sm:block">{{ Auth::user()->nama_lengkap }}</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="dropdownOpen" 
                             @click.away="dropdownOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-100 z-50"
                             style="display: none;">
                            
                            <div class="block px-4 py-2 text-[11px] text-gray-400 border-b border-gray-50 uppercase font-bold tracking-wider">
                                {{ Auth::user()->getRoleNames()->first() ?? Auth::user()->role }}
                            </div>

                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                Profil Saya
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold transition">
                                    Keluar (Logout)
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-6">
                    @isset($header)
                        <h2 class="text-xl lg:text-2xl font-semibold text-gray-800 mb-4 lg:mb-6">
                            {{ $header }}
                        </h2>
                    @endisset

                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>