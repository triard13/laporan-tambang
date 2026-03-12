<x-app-layout>
    <x-slot name="header">
        Dashboard KPI & Visualisasi Data
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            Selamat datang, {{ Auth::user()->nama_lengkap }}! Anda login sebagai <strong>{{ Auth::user()->role }}</strong>.
        </div>
    </div>
</x-app-layout>