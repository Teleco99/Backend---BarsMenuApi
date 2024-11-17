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
        Schema::create('menu_product', function (Blueprint $table) {
            $table->foreignId('menu_id')->constrained()->onDelete('cascade'); // Relación con menús
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relación con productos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_product');
    }
};
