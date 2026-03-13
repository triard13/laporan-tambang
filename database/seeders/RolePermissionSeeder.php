<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat daftar hak akses (Permissions)
        $permissions = ['dashboard', 'input', 'verifikasi', 'riwayat', 'pengguna', 'lokasi', 'alat'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Buat Role Admin & berikan semua akses
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->syncPermissions($permissions);

        // 3. Buat Role Supervisor & berikan akses terbatas
        $supervisor = Role::firstOrCreate(['name' => 'Supervisor']);
        $supervisor->syncPermissions(['dashboard', 'input', 'verifikasi', 'riwayat', 'lokasi', 'alat']);

        // 4. Buat Role Operator & berikan akses paling dasar
        $operator = Role::firstOrCreate(['name' => 'Operator']);
        $operator->syncPermissions(['dashboard', 'input', 'riwayat']);
    }
}