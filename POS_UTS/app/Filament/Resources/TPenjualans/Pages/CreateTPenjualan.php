<?php

namespace App\Filament\Resources\TPenjualans\Pages;

use App\Filament\Resources\TPenjualans\TPenjualanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTPenjualan extends CreateRecord
{
    protected static string $resource = TPenjualanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $today = date('Ymd');
        $lastTrx = \App\Models\TPenjualan::whereDate('penjualan_tanggal', date('Y-m-d'))->count();
        $data['penjualan_kode'] = 'TRX-' . $today . '-' . str_pad($lastTrx + 1, 4, '0', STR_PAD_LEFT);
        $data['user_id'] = \Filament\Facades\Filament::auth()->id();
        
        return $data;
    }
}
