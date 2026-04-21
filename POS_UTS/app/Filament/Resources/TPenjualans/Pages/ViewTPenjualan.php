<?php

namespace App\Filament\Resources\TPenjualans\Pages;

use App\Filament\Resources\TPenjualans\TPenjualanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTPenjualan extends ViewRecord
{
    protected static string $resource = TPenjualanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cetak_struk')
                ->label('Cetak Struk')
                ->color('success')
                ->icon('heroicon-o-printer')
                ->url(fn ($record) => route('pos.struk', $record->penjualan_kode))
                ->openUrlInNewTab(),
            EditAction::make(),
        ];
    }
}
