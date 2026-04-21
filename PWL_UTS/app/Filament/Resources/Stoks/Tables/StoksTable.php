<?php

namespace App\Filament\Resources\Stoks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StoksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('supplier.supplier_id')
                    ->searchable(),
                TextColumn::make('barang.barang_id')
                    ->searchable(),
                TextColumn::make('user.user_id')
                    ->searchable(),
                TextColumn::make('stok_tanggal')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('stok_jumlah')
                    ->numeric()
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
