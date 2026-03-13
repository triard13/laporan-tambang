<x-app-layout>
    <x-slot name="header">
        Edit Hak Akses Peran
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 px-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
            
            <div class="px-8 py-5 border-b border-gray-100 bg-blue-50/50 flex justify-between items-center">
                <h3 class="text-md font-bold text-blue-700 uppercase tracking-tight">Edit Akses: {{ $role->name }}</h3>
                <a href="{{ route('kontrol.akses') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                    &larr; Batal & Kembali
                </a>
            </div>

            <form action="{{ route('kontrol.update', $role->name) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <p class="text-sm text-gray-600">Centang modul yang diizinkan untuk diakses oleh peran <strong>{{ $role['nama'] }}</strong>.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-10">
                    @foreach($moduls as $modul)
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
                        <div>
                            <span class="block text-sm font-bold text-gray-700 capitalize">{{ str_replace('_', ' ', $modul) }}</span>
                            <span class="text-[11px] text-gray-400">Hak akses menu {{ $modul }}</span>
                        </div>

                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="akses[{{ $modul }}]" value="1" class="sr-only peer" {{ $role->hasPermissionTo($modul) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    @endforeach
                </div>

                <div class="pt-8 mt-6 border-t border-gray-100 flex gap-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-md font-bold text-sm shadow-sm transition">
                        Update Hak Akses
                    </button>
                    <a href="{{ route('kontrol.akses') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-8 py-2.5 rounded-md font-bold text-sm transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>