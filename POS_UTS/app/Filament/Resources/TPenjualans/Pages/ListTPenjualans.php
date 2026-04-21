<?php

namespace App\Filament\Resources\TPenjualans\Pages;

use App\Filament\Resources\TPenjualans\TPenjualanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTPenjualans extends ListRecords
{
    protected static string $resource = TPenjualanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
