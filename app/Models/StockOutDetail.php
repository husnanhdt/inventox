<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutDetail extends Model
{
    protected $table = 'stock_out_detail';
    protected $primaryKey = 'id_stock_out_detail';
    public $timestamps = true;

    protected $fillable = [
        'id_stock_out',
        'id_product',
        'jumlah_keluar'
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    // Relasi ke StockOut (opsional, tapi bagus untuk navigasi balik)
    public function stockOut()
    {
        return $this->belongsTo(StockOut::class, 'id_stock_out', 'id_stock_out');
    }
}