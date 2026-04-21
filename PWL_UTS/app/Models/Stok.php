<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table      = 't_stok';
    protected $primaryKey = 'stok_id';
    public    $timestamps = false;
    protected $fillable   = [
        'supplier_id', 'barang_id', 'user_id',
        'stok_tanggal', 'stok_jumlah'
    ];
    protected $casts = ['stok_tanggal' => 'datetime'];

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function barang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MUser::class, 'user_id', 'user_id');
    }
}
