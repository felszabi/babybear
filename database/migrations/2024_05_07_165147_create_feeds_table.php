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
        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('src')->nullable(true);
            $table->string('filename')->nullable(true);
            $table->string('keycolumn')->nullable(true);
            $table->text('connentedcols')->nullable(true);
            $table->double('pricemod')->nullable(false);
            $table->dateTime('downloaded')->default('2024-05-01 08:00:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeds');
    }
};
