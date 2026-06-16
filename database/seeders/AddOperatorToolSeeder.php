<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProduksiHarian;
use App\Models\User;
use App\Models\AlatTambang;
use Illuminate\Support\Facades\Hash;

class AddOperatorToolSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus riwayat laporan
        ProduksiHarian::query()->delete();
        $this->command->info('Riwayat Laporan Produksi Tambang berhasil dihapus.');

        // Tambah 4 operator
        $names = ['Budi Santoso', 'Andi Firmansyah', 'Siti Aminah', 'Rudi Hartono'];
        foreach ($names as $index => $name) {
            $i = $index + 1;
            $user = User::create([
                'nama_lengkap' => $name,
                'email' => 'operator_baru' . $i . '@tambang.com',
                'nomor_hp' => '08120000000' . $i,
                'role' => 'Operator',
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('Operator');
        }
        $this->command->info('4 Operator baru berhasil ditambahkan.');

        // Tambah alat
        $alats = [
            [
                'nama_alat' => 'Dump Truck Volvo FMX',
                'tipe_alat' => 'Dump Truck',
                'kapasitas' => '30 Ton',
                'kode_alat' => 'DT-01'
            ],
            [
                'nama_alat' => 'Dozer Komatsu D85ESS',
                'tipe_alat' => 'Bulldozer',
                'kapasitas' => '-',
                'kode_alat' => 'DZ-01'
            ],
            [
                'nama_alat' => 'Grader CAT 14M',
                'tipe_alat' => 'Motor Grader',
                'kapasitas' => '-',
                'kode_alat' => 'GR-01'
            ]
        ];

        foreach($alats as $alat) {
            AlatTambang::create($alat);
        }
        $this->command->info('Alat berat baru berhasil ditambahkan.');
    }
}
