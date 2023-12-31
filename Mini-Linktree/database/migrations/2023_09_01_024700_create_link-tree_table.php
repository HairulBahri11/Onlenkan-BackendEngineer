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
        Schema::create('link_tree', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('jenis_data', ['Icon', 'Gambar', 'Video']);
            $table->string('data');
            $table->integer('order');
            $table->string('link');
            $table->string('updated_by')->nullable();
            $table->enum('warna', ['primary', 'secondary', 'light']);
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_tree');
    }
};
