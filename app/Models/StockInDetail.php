<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInDetail extends Model
{
    protected $table = 'stock_in_detail'; // ✅ WAJIB karena nama tabel tidak ikut konvensi Laravel
    protected $primaryKey = 'id_stock_in_detail';
    public $timestamps = true;

    protected $fillable = ['id_stock_in', 'id_product', 'jumlah_masuk'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public function stockIn()
    {
        return $this->belongsTo(StockIn::class, 'id_stock_in', 'id_stock_in');
    }
}