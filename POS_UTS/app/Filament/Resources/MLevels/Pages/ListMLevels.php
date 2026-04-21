<?php

namespace App\Filament\Resources\MLevels\Pages;

use App\Filament\Resources\MLevels\MLevelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMLevels extends ListRecords
{
    protected static string $resource = MLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
