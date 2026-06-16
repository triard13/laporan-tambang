<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AddMoreOperatorsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $count = 30; // Tambah 30 operator agar proporsional dengan armada yang besar

        for ($i = 0; $i < $count; $i++) {
            $user = User::create([
                'nama_lengkap' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'nomor_hp' => $faker->phoneNumber,
                'role' => 'Operator',
                'password' => Hash::make('password')
            ]);
            $user->assignRole('Operator');
        }

        $this->command->info("Berhasil menambahkan $count operator baru secara otomatis.");
    }
}
