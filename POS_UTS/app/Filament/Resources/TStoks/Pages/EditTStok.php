<?php

namespace App\Filament\Resources\TStoks\Pages;

use App\Filament\Resources\TStoks\TStokResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTStok extends EditRecord
{
    protected static string $resource = TStokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
