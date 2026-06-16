<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produksi_harians', function (Blueprint $table) {
            $table->softDeletes();
            $table->index('tanggal');
            $table->index('status_laporan');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('alat_tambangs', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('lokasi_tambangs', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('produksi_harians', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex(['tanggal']);
            $table->dropIndex(['status_laporan']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('alat_tambangs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('lokasi_tambangs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
