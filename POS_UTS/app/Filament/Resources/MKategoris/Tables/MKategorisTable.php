<?php

namespace App\Filament\Resources\MKategoris\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Notifications\Notification;
use App\Models\MKategori;

class MKategorisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kategori_kode')
                    ->label('Kode Kategori')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kategori_nama')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('barang_count')
                    ->counts('barang')
                    ->label('Jumlah Barang')
                    ->badge()
                    ->color('info'),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make()
                        ->before(function (\Filament\Actions\DeleteBulkAction $action, $records) {
                            foreach ($records as $record) {
                                if ($record->barang()->exists()) {
                                    Notification::make()
                                        ->danger()
                                        ->title('Gagal menghapus beberapa data!')
                                        ->body("Kategori '{$record->kategori_nama}' masih memiliki barang terkait.")
                                        ->send();
                                    
                                    $action->halt();
                                    return;
                                }
                            }
                        }),
                    \Filament\Actions\RestoreBulkAction::make(),
                    \Filament\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}
