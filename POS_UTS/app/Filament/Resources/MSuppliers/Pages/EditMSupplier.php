<?php

namespace App\Filament\Resources\MSuppliers\Pages;

use App\Filament\Resources\MSuppliers\MSupplierResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMSupplier extends EditRecord
{
    protected static string $resource = MSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
