<?php

namespace App\Filament\Resources\LevelResource\Pages;

use App\Filament\Resources\LevelResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateLevel extends CreateRecord
{
    protected static string $resource = LevelResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Level berhasil ditambahkan.')
            ->body('Data level pengguna baru telah disimpan.');
    }
}
