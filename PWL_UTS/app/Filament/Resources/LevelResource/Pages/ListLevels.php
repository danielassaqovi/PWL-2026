<?php

namespace App\Filament\Resources\LevelResource\Pages;

use App\Filament\Resources\LevelResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListLevels extends ListRecords
{
    protected static string $resource = LevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Level Pengguna')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
