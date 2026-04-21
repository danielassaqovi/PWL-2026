<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table      = 'm_level';
    protected $primaryKey = 'level_id';
    public    $timestamps = false;
    protected $fillable   = ['level_kode', 'level_nama'];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MUser::class, 'level_id', 'level_id');
    }
}
