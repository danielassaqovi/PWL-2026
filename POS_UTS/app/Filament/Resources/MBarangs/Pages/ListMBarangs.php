<?php

namespace App\Filament\Resources\MBarangs\Pages;

use App\Filament\Resources\MBarangs\MBarangResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMBarangs extends ListRecords
{
    protected static string $resource = MBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
