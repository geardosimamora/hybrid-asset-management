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
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('asset_code')->unique();
            $table->string('name');

            // Syntax ini SUDAH mencakup pembuatan kolom dan relasi Foreign Key.
            // Jangan tambahkan $table->foreign() manual lagi di bawah.
            $table->foreignUuid('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignUuid('location_id')->constrained('locations')->restrictOnDelete();

            $table->decimal('purchase_price', 15, 2);
            $table->date('purchase_date');
            $table->integer('useful_life_years');
            $table->string('status')->default('active');

            $table->timestamps();
            $table->softDeletes(); 

            // Indexing untuk analitik Layer 2
            $table->index('category_id');
            $table->index('location_id');
            $table->index('status');
            $table->index('purchase_date');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
