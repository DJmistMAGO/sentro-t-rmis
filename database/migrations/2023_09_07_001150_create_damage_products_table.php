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
        Schema::create('damage_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('damage_prod_info_id')->references('id')->on('damage_prod_infos')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')->constrained()->onDelete('cascade');
            $table->double('quantity');
            $table->double('price');
            $table->double('total');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_products');
    }
};
