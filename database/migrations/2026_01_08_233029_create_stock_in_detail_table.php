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
        Schema::create('stock_in_detail', function (Blueprint $table) {
            $table->id('id_stock_in_detail');
            $table->foreignId('id_stock_in')->constrained('stock_ins', 'id_stock_in')->onDelete('cascade');
            $table->unsignedBigInteger('id_product'); // FK ke products.id_product
            $table->integer('jumlah_masuk')->check('jumlah_masuk > 0');
            $table->timestamps();

            $table->foreign('id_product')
                ->references('id_product')
                ->on('products')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in_detail');
    }
};
