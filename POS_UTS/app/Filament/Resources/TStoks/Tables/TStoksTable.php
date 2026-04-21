<?php

namespace App\Filament\Resources\TStoks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class TStoksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('stok_tanggal')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('supplier.supplier_nama')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('barang.barang_nama')
                    ->label('Barang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('stok_jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger'),
                TextColumn::make('user.nama')
                    ->label('Oleh')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
