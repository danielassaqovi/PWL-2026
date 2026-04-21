<?php

namespace App\Filament\Resources\MUsers\Pages;

use App\Filament\Resources\MUsers\MUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMUsers extends ListRecords
{
    protected static string $resource = MUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
