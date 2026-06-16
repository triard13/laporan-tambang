<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui informasi profil dan kontak Anda. Beberapa data yang bersifat administratif hanya dapat diubah oleh Administrator.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
            <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full" :value="old('nama_lengkap', $user->nama_lengkap)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('nama_lengkap')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-50 text-gray-500" :value="old('email', $user->email)" required readonly />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            <p class="text-xs text-gray-500 mt-1">Alamat email digunakan untuk login dan tidak dapat diubah sendiri.</p>
        </div>

        <div>
            <x-input-label for="nomor_hp" :value="__('Nomor HP / WhatsApp')" />
            <x-text-input id="nomor_hp" name="nomor_hp" type="text" class="mt-1 block w-full" :value="old('nomor_hp', $user->nomor_hp)" />
            <x-input-error class="mt-2" :messages="$errors->get('nomor_hp')" />
        </div>

        <hr class="border-gray-200">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label :value="__('NRP / NIK')" />
                <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500" :value="$user->nrp ?? '-'" disabled />
            </div>
            <div>
                <x-input-label :value="__('Hak Akses (Role)')" />
                <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500" :value="$user->role ?? '-'" disabled />
            </div>
            <div>
                <x-input-label :value="__('Jabatan Spesifik')" />
                <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500" :value="$user->jabatan ?? '-'" disabled />
            </div>
            <div>
                <x-input-label :value="__('Status Karyawan')" />
                <x-text-input type="text" class="mt-1 block w-full bg-gray-50 text-gray-500" :value="$user->status_karyawan ?? '-'" disabled />
            </div>
        </div>

        <div>
            <x-input-label for="foto_profil" :value="__('Foto Profil (Opsional)')" />
            
            <div class="mt-2 flex items-center gap-4">
                <div class="w-16 h-16 rounded-full overflow-hidden border border-gray-200 shadow-sm flex-shrink-0">
                    @if($user->foto_profil)
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Profil" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&background=random&color=fff" alt="Avatar" class="w-full h-full object-cover">
                    @endif
                </div>
                
                <input id="foto_profil" name="foto_profil" type="file" accept="image/png, image/jpeg, image/jpg" 
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-800 file:text-white hover:file:bg-gray-700 transition" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('foto_profil')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 font-bold"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
