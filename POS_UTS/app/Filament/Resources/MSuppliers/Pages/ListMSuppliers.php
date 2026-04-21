<?php

namespace App\Filament\Resources\MSuppliers\Pages;

use App\Filament\Resources\MSuppliers\MSupplierResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMSuppliers extends ListRecords
{
    protected static string $resource = MSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
