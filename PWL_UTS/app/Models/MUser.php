<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MUser extends Model
{
    protected $table      = 'm_user';
    protected $primaryKey = 'user_id';
    public    $timestamps = false;
    protected $fillable   = ['level_id', 'username', 'nama', 'password'];
    protected $hidden     = ['password'];

    public function level(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id', 'level_id');
    }

    public function stok(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Stok::class, 'user_id', 'user_id');
    }

    public function penjualan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Penjualan::class, 'user_id', 'user_id');
    }
}
