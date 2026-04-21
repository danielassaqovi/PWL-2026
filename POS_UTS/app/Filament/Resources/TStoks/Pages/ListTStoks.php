<?php

namespace App\Filament\Resources\TStoks\Pages;

use App\Filament\Resources\TStoks\TStokResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTStoks extends ListRecords
{
    protected static string $resource = TStokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
