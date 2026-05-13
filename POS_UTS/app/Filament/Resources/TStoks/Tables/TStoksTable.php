<?php

namespace App\Filament\Resources\TStoks\Tables;

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
                TextColumn::make('barang.barang_nama')
                    ->label('Barang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('supplier.supplier_nama')
                    ->label('Supplier')
                    ->placeholder('Internal')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('stok_jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger'),
                TextColumn::make('keterangan')
                    ->label('Alasan/Ket')
                    ->placeholder('Masok Barang')
                    ->searchable(),
                TextColumn::make('user.nama')
                    ->label('Petugas')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
