<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';
    public $timestamps = false;

    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
    ];

    // Relasi: Barang belong to Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    // Relasi: Barang memiliki banyak Stok
    public function stok()
    {
        return $this->hasMany(Stok::class, 'barang_id', 'barang_id');
    }

    // Relasi: Barang memiliki banyak PenjualanDetail
    public function penjualanDetail()
    {
        return $this->hasMany(PenjualanDetail::class, 'barang_id', 'barang_id');
    }
}
