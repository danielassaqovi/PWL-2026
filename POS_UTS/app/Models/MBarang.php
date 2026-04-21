<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class MBarang extends Model
{
    use SoftDeletes;

    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';
    protected $fillable = ['kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(MKategori::class, 'kategori_id', 'kategori_id');
    }

    public function stok(): HasMany
    {
        return $this->hasMany(TStok::class, 'barang_id', 'barang_id');
    }

    public function penjualan_detail(): HasMany
    {
        return $this->hasMany(TPenjualanDetail::class, 'barang_id', 'barang_id');
    }

    protected function hargaBeliFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->harga_beli, 0, ',', '.'),
        );
    }

    protected function hargaJualFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->harga_jual, 0, ',', '.'),
        );
    }
}
