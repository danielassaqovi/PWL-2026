<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table      = 't_penjualan_detail';
    protected $primaryKey = 'detail_id';
    public    $timestamps = false;
    protected $fillable   = [
        'penjualan_id', 'barang_id', 'harga', 'jumlah'
    ];

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'penjualan_id');
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }

    public function getSubtotalAttribute(): int
    {
        return $this->harga * $this->jumlah;
    }
}
