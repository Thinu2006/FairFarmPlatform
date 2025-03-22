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
        Schema::create('paddy_types', function (Blueprint $table) {
            $table->id('PaddyID');
            $table->string('PaddyName')->unique();
            $table->decimal('MaxPricePerKg', 8, 2);
            $table->string('Image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paddy_types');
    }
};
