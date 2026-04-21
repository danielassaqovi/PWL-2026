<?php

namespace App\Filament\Resources\MKategoris\Pages;

use App\Filament\Resources\MKategoris\MKategoriResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMKategori extends EditRecord
{
    protected static string $resource = MKategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
