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
            $table->id('id_product');
            $table->foreignId('id_category')->constrained('categories', 'id_category')->onDelete('restrict');
            $table->string('nama_barang', 100);
            $table->integer('stok')->default(0)->check('stok >= 0');
            $table->integer('minimal_stok')->default(5);
            $table->string('satuan', 50)->default('pcs');
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
