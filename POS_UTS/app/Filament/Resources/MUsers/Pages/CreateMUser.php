<?php

namespace App\Filament\Resources\MUsers\Pages;

use App\Filament\Resources\MUsers\MUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMUser extends CreateRecord
{
    protected static string $resource = MUserResource::class;
}
