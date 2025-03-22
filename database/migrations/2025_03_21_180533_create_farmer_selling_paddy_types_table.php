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
            $table->id(); // Primary key
            $table->unsignedBigInteger('FarmerID'); // Foreign key to the farmers table
            $table->unsignedBigInteger('PaddyID'); // Foreign key to the paddy_types table
            $table->decimal('PriceSelected', 8, 2); // Price selected by the farmer (per kg)
            $table->integer('Quantity'); // Quantity of paddy (in kg)
            $table->timestamps(); // Created at and updated at timestamps
        
            // Foreign key constraints
            $table->foreign('FarmerID')->references('FarmerID')->on('farmers')->onDelete('cascade');
            $table->foreign('PaddyID')->references('PaddyID')->on('paddy_types')->onDelete('cascade');
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
