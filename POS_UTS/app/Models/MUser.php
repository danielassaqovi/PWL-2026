<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MUser extends Authenticatable implements FilamentUser, HasName
{
    use SoftDeletes;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['level_id', 'username', 'nama', 'password'];

    public function getFilamentName(): string
    {
        return $this->nama;
    }

    protected $hidden = [
        'password',
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(MLevel::class, 'level_id', 'level_id');
    }

    public function stok(): HasMany
    {
        return $this->hasMany(TStok::class, 'user_id', 'user_id');
    }

    public function penjualan(): HasMany
    {
        return $this->hasMany(TPenjualan::class, 'user_id', 'user_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Allow access to standard users for demo purposes
        return true; 
    }
}
