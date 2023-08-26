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
        Schema::create('purchase_product_infos', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->string('reference_no');
            $table->string('prepared_by');
            $table->date('date_preparation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_product_infos');
    }
};