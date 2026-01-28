<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $table = 'stock_outs';
    protected $primaryKey = 'id_stock_out';
    public $timestamps = true;

    // ✅ Tambahkan ini
    protected $dates = ['tanggal_keluar'];

    protected $fillable = ['id_user', 'tanggal_keluar', 'keterangan'];

    protected $casts = [
        'tanggal_keluar' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(StockOutDetail::class, 'id_stock_out', 'id_stock_out');
    }
}