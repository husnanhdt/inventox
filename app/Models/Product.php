<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id_product';
    protected $fillable = ['id_category', 'nama_barang', 'stok', 'minimal_stok', 'satuan', 'foto'];

    public function category() { return $this->belongsTo(Category::class, 'id_category', 'id_category'); }
    public function stockInDetails() { return $this->hasMany(StockInDetail::class, 'id_product', 'id_product'); }
    public function stockOutDetails() { return $this->hasMany(StockOutDetail::class, 'id_product', 'id_product'); }
}
