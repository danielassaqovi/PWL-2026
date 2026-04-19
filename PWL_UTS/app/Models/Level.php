<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'm_level';
    protected $primaryKey = 'level_id';
    public $timestamps = false;

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];

    // Relasi: Level memiliki banyak User
    public function users()
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}
