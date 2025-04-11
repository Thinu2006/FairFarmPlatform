<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('farmer_id');
            $table->unsignedBigInteger('paddy_type_id');
            $table->decimal('price_per_kg', 10, 2);
            $table->decimal('quantity', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
            
            $table->foreign('buyer_id')->references('BuyerID')->on('buyers')->onDelete('cascade');
            $table->foreign('farmer_id')->references('FarmerID')->on('farmers')->onDelete('cascade');
            $table->foreign('paddy_type_id')->references('PaddyID')->on('paddy_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};