<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi: UserModel belong to Level
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'level_id');
    }

    // Relasi: UserModel memiliki banyak Stok
    public function stok()
    {
        return $this->hasMany(Stok::class, 'user_id', 'user_id');
    }

    // Relasi: UserModel memiliki banyak Penjualan
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'user_id', 'user_id');
    }
}
