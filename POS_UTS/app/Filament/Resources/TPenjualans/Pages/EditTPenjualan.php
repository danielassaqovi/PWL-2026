<?php

namespace App\Filament\Resources\TPenjualans\Pages;

use App\Filament\Resources\TPenjualans\TPenjualanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTPenjualan extends EditRecord
{
    protected static string $resource = TPenjualanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
