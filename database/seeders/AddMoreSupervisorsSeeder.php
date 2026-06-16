<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AddMoreSupervisorsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $count = 4; // Tambah 4 Supervisor untuk operasi skala besar

        for ($i = 0; $i < $count; $i++) {
            $user = User::create([
                'nama_lengkap' => 'SPV - ' . $faker->name,
                'email' => 'supervisor_baru' . ($i + 1) . '@tambang.com',
                'nomor_hp' => $faker->phoneNumber,
                'role' => 'Supervisor',
                'password' => Hash::make('password')
            ]);
            $user->assignRole('Supervisor');
        }

        $this->command->info("Berhasil menambahkan $count supervisor baru.");
    }
}
