<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlatTambang;

class AddMoreToolsSeeder extends Seeder
{
    public function run(): void
    {
        $alats = [
            // Excavator
            ['nama_alat' => 'Excavator CAT 330 GC', 'tipe_alat' => 'Excavator', 'kapasitas' => '30 Ton', 'kode_alat' => 'EXC-02'],
            ['nama_alat' => 'Excavator Komatsu PC300', 'tipe_alat' => 'Excavator', 'kapasitas' => '32 Ton', 'kode_alat' => 'EXC-03'],
            ['nama_alat' => 'Excavator Hitachi Zaxis 330', 'tipe_alat' => 'Excavator', 'kapasitas' => '33 Ton', 'kode_alat' => 'EXC-04'],
            ['nama_alat' => 'Excavator Volvo EC300D', 'tipe_alat' => 'Excavator', 'kapasitas' => '30 Ton', 'kode_alat' => 'EXC-05'],
            ['nama_alat' => 'Excavator CAT 390F', 'tipe_alat' => 'Excavator', 'kapasitas' => '90 Ton', 'kode_alat' => 'EXC-06'],
            // Dump Truck Scania
            ['nama_alat' => 'Dump Truck Scania P410 (Unit 1)', 'tipe_alat' => 'Dump Truck', 'kapasitas' => '30 Ton', 'kode_alat' => 'DT-02'],
            ['nama_alat' => 'Dump Truck Scania P410 (Unit 2)', 'tipe_alat' => 'Dump Truck', 'kapasitas' => '30 Ton', 'kode_alat' => 'DT-03'],
            ['nama_alat' => 'Dump Truck Scania P410 (Unit 3)', 'tipe_alat' => 'Dump Truck', 'kapasitas' => '30 Ton', 'kode_alat' => 'DT-04'],
            // Dump Truck Volvo
            ['nama_alat' => 'Dump Truck Volvo FMX 440 (Unit 1)', 'tipe_alat' => 'Dump Truck', 'kapasitas' => '35 Ton', 'kode_alat' => 'DT-05'],
            ['nama_alat' => 'Dump Truck Volvo FMX 440 (Unit 2)', 'tipe_alat' => 'Dump Truck', 'kapasitas' => '35 Ton', 'kode_alat' => 'DT-06'],
            ['nama_alat' => 'Dump Truck Volvo FMX 440 (Unit 3)', 'tipe_alat' => 'Dump Truck', 'kapasitas' => '35 Ton', 'kode_alat' => 'DT-07'],
            ['nama_alat' => 'Dump Truck Volvo FMX 440 (Unit 4)', 'tipe_alat' => 'Dump Truck', 'kapasitas' => '35 Ton', 'kode_alat' => 'DT-08'],
            // Dump Truck Hino
            ['nama_alat' => 'Dump Truck Hino 500 FM (Unit 1)', 'tipe_alat' => 'Dump Truck', 'kapasitas' => '26 Ton', 'kode_alat' => 'DT-09'],
            ['nama_alat' => 'Dump Truck Hino 500 FM (Unit 2)', 'tipe_alat' => 'Dump Truck', 'kapasitas' => '26 Ton', 'kode_alat' => 'DT-10'],
            ['nama_alat' => 'Dump Truck Hino 500 FM (Unit 3)', 'tipe_alat' => 'Dump Truck', 'kapasitas' => '26 Ton', 'kode_alat' => 'DT-11'],
        ];

        foreach($alats as $alat) {
            AlatTambang::create($alat);
        }
        $this->command->info('Alat berat tambahan berhasil dibuat (' . count($alats) . ' unit).');
    }
}
