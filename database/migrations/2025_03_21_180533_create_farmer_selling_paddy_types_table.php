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
        Schema::create('farmer_selling_paddy_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FarmerID');
            $table->unsignedBigInteger('PaddyID');
            $table->decimal('PriceSelected', 8, 2);
            $table->integer('Quantity');
            $table->timestamps();
            
            $table->foreign('FarmerID')->references('FarmerID')->on('farmers')->onDelete('cascade');
            $table->foreign('PaddyID')->references('PaddyID')->on('paddy_types')->onDelete('cascade');
            
            // Add unique constraint
            $table->unique(['FarmerID', 'PaddyID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_selling_paddy_types');
    }
};
