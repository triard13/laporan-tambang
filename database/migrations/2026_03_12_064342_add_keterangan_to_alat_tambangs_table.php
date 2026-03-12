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
        Schema::table('alat_tambangs', function (Blueprint $table) {
            $table->integer('jam_kerja')->default(0)->after('kapasitas');
            $table->enum('status', ['Aktif', 'Perawatan', 'Rusak'])->default('Aktif')->after('jam_kerja');
        });
    }

    public function down(): void
    {
        Schema::table('alat_tambangs', function (Blueprint $table) {
            $table->dropColumn(['jam_kerja', 'status']);
        });
    }
};
