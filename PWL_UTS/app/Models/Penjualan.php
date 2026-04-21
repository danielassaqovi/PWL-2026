<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table      = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    public    $timestamps = false;
    protected $fillable   = [
        'user_id', 'pembeli',
        'penjualan_kode', 'penjualan_tanggal'
    ];
    protected $casts = ['penjualan_tanggal' => 'datetime'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MUser::class, 'user_id', 'user_id');
    }

    public function detail(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id', 'penjualan_id');
    }

    public function getTotalHargaAttribute(): int
    {
        return $this->detail->sum(fn($d) => $d->harga * $d->jumlah);
    }
}
