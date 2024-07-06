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
        Schema::create('product_attribute_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('products_id')->references('id')->on('products')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('attribute_items_id')->references('id')->on('attribute_items')->restrictOnDelete()->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_items');
    }
};
