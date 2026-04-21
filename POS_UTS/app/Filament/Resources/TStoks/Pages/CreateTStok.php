<?php

namespace App\Filament\Resources\TStoks\Pages;

use App\Filament\Resources\TStoks\TStokResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTStok extends CreateRecord
{
    protected static string $resource = TStokResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = \Filament\Facades\Filament::auth()->id();

        return $data;
    }
}
