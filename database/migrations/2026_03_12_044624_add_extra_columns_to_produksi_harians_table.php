<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produksi_harians', function (Blueprint $blueprint) {
            // Menambah kolom sesuai UI baru
            $blueprint->string('shift')->default('Shift 1')->after('tanggal');
            $blueprint->integer('jarak_angkut')->default(500)->after('volume');
            $blueprint->string('cuaca')->default('Cerah')->after('bahan_bakar');
            $blueprint->string('hambatan_operasional')->default('Tidak Ada')->after('cuaca');
            $blueprint->text('catatan_tambahan')->nullable()->after('hambatan_operasional');
        });
    }

    public function down(): void
    {
        Schema::table('produksi_harians', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['shift', 'jarak_angkut', 'cuaca', 'hambatan_operasional', 'catatan_tambahan']);
        });
    }
};