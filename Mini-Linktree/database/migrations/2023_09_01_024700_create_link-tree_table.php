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
            $table->string('icon');
            $table->integer('order');
            $table->string('link');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->enum('warna', ['primary', 'secondary', 'light']);
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
