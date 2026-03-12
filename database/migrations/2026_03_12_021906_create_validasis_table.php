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
        Schema::create('validasis', function (Blueprint $table) {
            $table->id(); // id_validasi
            $table->foreignId('produksi_harian_id')->constrained('produksi_harians')->onDelete('cascade'); // id_produksi
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // id_user (supervisor)
            $table->dateTime('tanggal_validasi');
            $table->enum('status_validasi', ['Disetujui', 'Ditolak', 'Revisi']);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validasis');
    }
};
