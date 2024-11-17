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
        Schema::create('admin_product', function (Blueprint $table) {
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // El administrador que creó el recurso
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade'); // El menú creado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_product');
    }
};
