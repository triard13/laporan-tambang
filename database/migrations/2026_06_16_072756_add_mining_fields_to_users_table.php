<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nrp')->unique()->nullable()->after('email');
            $table->string('jabatan')->nullable()->after('role');
            $table->enum('status_karyawan', ['Aktif', 'Non-Aktif'])->default('Aktif')->after('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nrp', 'jabatan', 'status_karyawan']);
        });
    }
};
