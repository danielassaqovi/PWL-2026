<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TPenjualan extends Model
{
    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    protected $fillable = ['user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(MUser::class, 'user_id', 'user_id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(TPenjualanDetail::class, 'penjualan_id', 'penjualan_id');
    }

    protected function totalPenjualan(): Attribute
    {
        return Attribute::make(
            get: function () {
                $total = $this->detail->sum(function ($item) {
                    return $item->harga * $item->jumlah;
                });
                return 'Rp ' . number_format($total, 0, ',', '.');
            }
        );
    }
}
