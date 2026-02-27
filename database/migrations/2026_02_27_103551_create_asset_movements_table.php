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
        Schema::create('asset_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('asset_id')->constrained()->onDelete('restrict');
            $table->foreignId('moved_by')->constrained('users')->restrictOnDelete();
            $table->foreignUuid('from_location_id')->constrained('locations')->onDelete('restrict');
            $table->foreignUuid('to_location_id')->constrained('locations')->onDelete('restrict');
            $table->timestamp('moved_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexing untuk performa query yang lebih baik
            $table->index('asset_id');
            $table->index('moved_at');
            $table->index(['from_location_id', 'to_location_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_movements');
    }
};
