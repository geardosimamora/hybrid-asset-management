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
        Schema::create('categories', function (Blueprint $table) {
            // Menggunakan UUID sebagai Primary Key
            $table->uuid('id')->primary();
            
            // Nama kategori harus unik (contoh: Elektronik, Furniture)
            $table->string('name')->unique();
            
            // Deskripsi opsional
            $table->string('description')->nullable();
            
            // created_at & updated_at
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};