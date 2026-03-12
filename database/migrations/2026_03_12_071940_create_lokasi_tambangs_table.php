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
        Schema::create('lokasi_tambangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi'); // misal: Blok A
            $table->string('koordinat')->nullable(); // misal: -3.2178, 115.5604
            $table->integer('luas_area')->nullable(); // misal: 50 (dalam Hektar)
            $table->string('koordinator')->nullable(); // misal: Agus Wijaya
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_tambangs');
    }
};
