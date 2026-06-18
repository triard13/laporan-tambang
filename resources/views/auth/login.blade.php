<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laporan Tambang') }} - Masuk</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-[1000px] rounded-[1.5rem] shadow-2xl flex overflow-hidden min-h-[600px]">
        <!-- Left Side (Form) -->
        <div class="w-full md:w-1/2 p-8 md:p-10 lg:p-12 flex flex-col justify-between">
            
            <!-- Logo Section -->
            <div class="flex items-center space-x-2 mb-8">
                <div class="w-8 h-8 bg-emerald-600 rounded flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-xl font-bold text-gray-900 tracking-tight">Laporan<span class="font-normal text-gray-500">Tambang</span></span>
            </div>

            <!-- Form Container -->
            <div class="w-full mx-auto flex-grow flex flex-col justify-center">
                <h2 class="text-[1.75rem] font-bold text-gray-900 mb-2">Selamat Datang Kembali!</h2>
                <p class="text-sm text-gray-400 mb-8 font-medium">Silakan masukkan email dan kata sandi Anda untuk mengakses Dasbor Laporan Tambang</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="mis. admin@mail.com"
                               class="block w-full border border-gray-200 rounded-lg shadow-sm py-2.5 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 placeholder-gray-300 transition-colors" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 mb-1.5">Kata Sandi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi Anda"
                                   class="block w-full border border-gray-200 rounded-lg shadow-sm py-2.5 px-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 placeholder-gray-300 transition-colors" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer hover:text-gray-600" onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
                    </div>

                    <!-- Forgot Password -->
                    <div class="flex justify-end mt-1 mb-6">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-emerald-500 hover:text-emerald-600 transition-colors">
                                Lupa Kata Sandi?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                            Masuk
                        </button>
                    </div>


                </form>
            </div>

            <!-- Footer -->
            <div class="mt-8 flex justify-between items-center text-xs font-medium text-gray-400">
                <p>Hak Cipta &copy; {{ date('Y') }} Laporan Tambang</p>
                <a href="#" class="hover:text-emerald-500 transition-colors underline decoration-transparent hover:decoration-emerald-500 underline-offset-2">Pemberitahuan Privasi</a>
            </div>
        </div>

        <!-- Right Side (Pattern/Image) -->
        <div class="hidden md:flex md:w-1/2 bg-[#022c22] relative items-center justify-center overflow-hidden">
            <!-- Pattern SVG -->
            <svg class="absolute inset-0 w-full h-full opacity-20" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                <defs>
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#10b981" stroke-width="1"/>
                        <rect x="0" y="0" width="10" height="10" fill="#10b981" fill-opacity="0.1"/>
                        <rect x="20" y="10" width="10" height="10" fill="#10b981" fill-opacity="0.2"/>
                        <rect x="10" y="30" width="10" height="10" fill="#10b981" fill-opacity="0.15"/>
                        <rect x="30" y="20" width="10" height="10" fill="#10b981" fill-opacity="0.3"/>
                        <rect x="0" y="20" width="10" height="10" fill="#10b981" fill-opacity="0.1"/>
                        <rect x="20" y="30" width="10" height="10" fill="#10b981" fill-opacity="0.05"/>
                        <rect x="10" y="10" width="10" height="10" fill="#10b981" fill-opacity="0.25"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)"/>
            </svg>
            
            <div class="z-10 flex items-center space-x-3 text-white">
                <div class="w-12 h-12 bg-white rounded flex items-center justify-center">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-2xl font-bold tracking-tight leading-none mb-1">Laporan</span>
                    <span class="text-[1.1rem] tracking-wide font-light opacity-90 leading-none">Tambang</span>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
