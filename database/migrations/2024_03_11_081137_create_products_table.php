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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable(true);
            $table->string('manufacturer')->nullable(true);
            $table->string('sku');
            $table->double('price')->nullable(false);
            $table->double('sale_price')->nullable(true);
            $table->string('index_image')->nullable(true);
            $table->text('description')->nullable(true);
            $table->text('short_description')->nullable(true);
            $table->integer('status')->comment('status id');
            $table->string('ean');
            $table->integer('stock')->nullable(true);
            $table->string('connection_key')->nullable(true)->comment('id or product sku'); 
            $table->string('connection')->nullable(true)->comment('from where the product comes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
