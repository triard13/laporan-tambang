<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LokasiTambang;

class RealisticLocationSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama
        LokasiTambang::truncate(); // Sqlite support delete if truncate fails but let's just use delete()
        LokasiTambang::query()->delete();

        $lokasis = [
            [
                'nama_lokasi' => 'Pit Alpha (Utara)',
                'koordinat' => '-3.2178, 115.5604',
                'luas_area' => 120,
                'koordinator' => 'Agus Wijaya'
            ],
            [
                'nama_lokasi' => 'Pit Bravo (Selatan)',
                'koordinat' => '-3.2210, 115.5580',
                'luas_area' => 85,
                'koordinator' => 'Budi Santoso'
            ],
            [
                'nama_lokasi' => 'Pit Charlie (Timur)',
                'koordinat' => '-3.2250, 115.5650',
                'luas_area' => 150,
                'koordinator' => 'Andi Firmansyah'
            ],
            [
                'nama_lokasi' => 'Disposal Area North',
                'koordinat' => '-3.2050, 115.5610',
                'luas_area' => 60,
                'koordinator' => 'Siti Aminah'
            ],
            [
                'nama_lokasi' => 'Disposal Area South',
                'koordinat' => '-3.2350, 115.5550',
                'luas_area' => 75,
                'koordinator' => 'Rudi Hartono'
            ],
            [
                'nama_lokasi' => 'ROM Stockpile Utama',
                'koordinat' => '-3.2150, 115.5700',
                'luas_area' => 20,
                'koordinator' => 'Agus Wijaya'
            ]
        ];

        foreach ($lokasis as $lokasi) {
            LokasiTambang::create($lokasi);
        }

        $this->command->info('Data Manajemen Lokasi yang realistis berhasil dibuat.');
    }
}
