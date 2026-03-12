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
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex h-screen overflow-hidden">
            
            <aside class="w-64 bg-[#2b2b36] text-white flex flex-col shadow-lg">
                <div class="h-16 flex items-center justify-center border-b border-gray-700 mt-4 pb-4">
                    <div class="text-xl font-bold flex items-center gap-2">
                        <span>📊 Laporan Tambang</span>
                    </div>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto text-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Dashboard</a>
                    
                    @if(Auth::user()->role == 'Operator' || Auth::user()->role == 'Supervisor')
                        <a href="{{ route('laporan.create') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('laporan.create') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Input Laporan</a>
                    @endif

                    @if(Auth::user()->role == 'Supervisor')
                        <a href="{{ route('laporan.verifikasi') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('laporan.verifikasi') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Verifikasi Laporan</a>
                    @endif

                    <a href="{{ route('laporan.riwayat') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('laporan.riwayat') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Riwayat Laporan</a>
                    
                    @if(Auth::user()->role == 'Admin')
                        <a href="{{ route('manajemen.users') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('manajemen.users') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Manajemen Pengguna</a>
                        <a href="{{ route('manajemen.alat') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('manajemen.alat') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Manajemen Alat</a>
                        <a href="{{ route('manajemen.lokasi') }}" class="block px-4 py-3 rounded-md transition {{ request()->routeIs('manajemen.lokasi') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">Manajemen Lokasi</a>
                    @endif
                </nav>
            </aside>

            <div class="flex-1 flex flex-col overflow-hidden">
                
                <header class="h-16 bg-white border-b flex items-center justify-end px-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-700 font-medium">{{ Auth::user()->nama_lengkap }} ({{ Auth::user()->role }})</span>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                    @isset($header)
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                            {{ $header }}
                        </h2>
                    @endisset

                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>