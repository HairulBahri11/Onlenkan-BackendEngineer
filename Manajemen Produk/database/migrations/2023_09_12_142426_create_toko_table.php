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
        Schema::create('toko', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko');
            $table->string('alamat_toko');
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->string('no_telp');
            $table->string('foto_toko');
            $table->text('deskripsi_toko');
            $table->date('tanggal_berdiri');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko');
    }
};
