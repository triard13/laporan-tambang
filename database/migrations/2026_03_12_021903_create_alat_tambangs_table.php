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
        Schema::create('alat_tambangs', function (Blueprint $table) {
            $table->id(); // Ini jadi id_alat
            $table->string('nama_alat');
            $table->string('tipe_alat');
            $table->string('kapasitas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_tambangs');
    }
};
