<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        // Membuat akun Admin
        $admin = User::create([
            'nama_lengkap' => 'Administrator Sistem',
            'email' => 'admin@tambang.com',
            'nomor_hp' => '081100001111',
            'role' => 'Admin',
            'password' => Hash::make('password'), // passwordnya: password
        ]);
        $admin->assignRole('Admin');

        // Membuat akun Supervisor
        $supervisor = User::create([
            'nama_lengkap' => 'Agus Wijaya', // Mengambil nama dari desain UI proposal Anda
            'email' => 'supervisor@tambang.com',
            'nomor_hp' => '081100002222',
            'role' => 'Supervisor',
            'password' => Hash::make('password'),
        ]);
        $supervisor->assignRole('Supervisor');

        // Membuat akun Operator
        $operatorUser = User::create([
                'nama_lengkap' => 'Joko Prasetyo', // Mengambil nama dari desain UI proposal Anda
                'email' => 'operator@tambang.com',
                'nomor_hp' => '081100003333',
                'role' => 'Operator',
                'password' => Hash::make('password'),
            ]);
        $operatorUser->assignRole('Operator');

            $alat = \App\Models\AlatTambang::firstOrCreate(['nama_alat' => 'Exca-01 : CAT 320D'], [
            'tipe_alat' => 'Excavator',
            'kapasitas' => '1200'
        ]);

        $operator = \App\Models\User::where('role', 'Operator')->first();

        // Loop untuk membuat data 14 hari terakhir
        for ($i = 14; $i >= 0; $i--) {
            $tanggal = now()->subDays($i);
            
            \App\Models\ProduksiHarian::create([
                'user_id' => $operator->id,
                'alat_tambang_id' => $alat->id,
                'tanggal' => $tanggal,
                'material' => 'Overburden',
                'volume' => rand(1000, 1500), // Data dummy volume
                'jam_operasi' => 8,
                'lokasi' => rand(0, 1) ? 'Blok A' : 'Blok B',
                'bahan_bakar' => 220,
                'status_laporan' => 'Disetujui' // Pastikan disetujui agar muncul di grafik
            ]);
        }
    }
}