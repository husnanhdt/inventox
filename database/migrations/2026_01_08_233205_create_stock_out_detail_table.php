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
        Schema::create('stock_out_detail', function (Blueprint $table) {
            $table->id('id_stock_out_detail');
            $table->foreignId('id_stock_out')->constrained('stock_outs', 'id_stock_out')->onDelete('cascade');
            $table->unsignedBigInteger('id_product');
            $table->integer('jumlah_keluar')->check('jumlah_keluar > 0');
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
        Schema::dropIfExists('stock_out_detail');
    }
};
