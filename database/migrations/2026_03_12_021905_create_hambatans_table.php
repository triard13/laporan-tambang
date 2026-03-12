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
        Schema::create('hambatans', function (Blueprint $table) {
            $table->id(); // id_hambatan
            $table->foreignId('produksi_harian_id')->constrained('produksi_harians')->onDelete('cascade'); // id_produksi
            $table->string('jenis_hambatan');
            $table->integer('durasi'); // dalam menit/jam
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hambatans');
    }
};
