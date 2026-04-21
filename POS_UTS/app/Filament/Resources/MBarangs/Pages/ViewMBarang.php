<?php

namespace App\Filament\Resources\MBarangs\Pages;

use App\Filament\Resources\MBarangs\MBarangResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMBarang extends ViewRecord
{
    protected static string $resource = MBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
