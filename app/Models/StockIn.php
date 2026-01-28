<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $table = 'stock_ins';
    protected $primaryKey = 'id_stock_in';
    public $timestamps = true;

    // ✅ Tambahkan ini
    protected $dates = ['tanggal_masuk'];

    protected $fillable = ['id_user', 'tanggal_masuk', 'keterangan'];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(StockInDetail::class, 'id_stock_in', 'id_stock_in');
    }
}