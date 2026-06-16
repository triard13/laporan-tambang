<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produksi_harians', function (Blueprint $table) {
            $table->dropColumn('lokasi');
            $table->foreignId('lokasi_tambang_id')->nullable()->constrained('lokasi_tambangs')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('produksi_harians', function (Blueprint $table) {
            $table->dropForeign(['lokasi_tambang_id']);
            $table->dropColumn('lokasi_tambang_id');
            $table->string('lokasi')->nullable();
        });
    }
};
