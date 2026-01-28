<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_user';
    public $incrementing = true; // karena id_user auto-increment
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi
    public function stockIns()
    {
        return $this->hasMany(\App\Models\StockIn::class, 'id_user', 'id_user');
    }

    public function stockOuts()
    {
        return $this->hasMany(\App\Models\StockOut::class, 'id_user', 'id_user');
    }
}