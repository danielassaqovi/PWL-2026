<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TStok extends Model
{
    protected $table = 't_stok';
    protected $primaryKey = 'stok_id';
    protected $fillable = ['supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah'];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(MSupplier::class, 'supplier_id', 'supplier_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(MBarang::class, 'barang_id', 'barang_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(MUser::class, 'user_id', 'user_id');
    }
}
