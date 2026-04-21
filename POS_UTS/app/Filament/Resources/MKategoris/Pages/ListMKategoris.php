<?php

namespace App\Filament\Resources\MKategoris\Pages;

use App\Filament\Resources\MKategoris\MKategoriResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMKategoris extends ListRecords
{
    protected static string $resource = MKategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
