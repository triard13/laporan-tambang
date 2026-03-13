<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="flex justify-center mb-4">
            <div class="w-16 h-16 bg-[#2b2b36] rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-3xl">📊</span>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Laporan Tambang</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan masuk ke akun Anda</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-bold text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                   class="block mt-2 w-full border-gray-300 focus:border-[#3e8e63] focus:ring-[#3e8e63] rounded-md shadow-sm text-sm py-2.5" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
        </div>

        <div>
            <label for="password" class="block text-sm font-bold text-gray-700">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                   class="block mt-2 w-full border-gray-300 focus:border-[#3e8e63] focus:ring-[#3e8e63] rounded-md shadow-sm text-sm py-2.5" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" 
                       class="rounded border-gray-300 text-[#3e8e63] shadow-sm focus:ring-[#3e8e63]">
                <span class="ms-2 text-sm text-gray-600 font-medium">Ingat Saya</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-6 pt-2">
            <button type="submit" class="w-full justify-center inline-flex items-center px-4 py-3 bg-[#3e8e63] hover:bg-emerald-700 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-[#3e8e63] focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                MASUK KE SISTEM
            </button>
        </div>
    </form>
</x-guest-layout>