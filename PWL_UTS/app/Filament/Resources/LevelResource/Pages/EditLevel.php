<?php

namespace App\Filament\Resources\LevelResource\Pages;

use App\Filament\Resources\LevelResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditLevel extends EditRecord
{
    protected static string $resource = LevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Level berhasil dihapus.')
                ),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Level berhasil diperbarui.')
            ->body('Perubahan data level pengguna telah disimpan.');
    }
}
