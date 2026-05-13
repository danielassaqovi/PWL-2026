<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MSetting extends Model
{
    protected $table = 'm_setting';
    protected $primaryKey = 'setting_id';
    protected $fillable = ['key', 'value', 'keterangan'];

    public static function getTaxPercentage(): float
    {
        $setting = self::where('key', 'pajak_persentase')->first();
        return (float) ($setting->value ?? 0);
    }
}
