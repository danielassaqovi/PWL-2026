<?php

namespace App\Filament\Resources\MUsers\Pages;

use App\Filament\Resources\MUsers\MUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMUser extends EditRecord
{
    protected static string $resource = MUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
