<?php

namespace App\Filament\Resources\MBarangs\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use App\Models\MBarang;

class MBarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('barang_kode')
                    ->label('Kode Barang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('barang_nama')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_stok')
                    ->label('Stok Tersedia')
                    ->suffix(' unit')
                    ->badge()
                    ->color(fn ($state) => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger'))
                    ->sortable(),
                TextColumn::make('kategori.kategori_nama')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('harga_jual')
                    ->label('Harga Jual')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    \Filament\Actions\ForceDeleteBulkAction::make(),
                    \Filament\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
}
