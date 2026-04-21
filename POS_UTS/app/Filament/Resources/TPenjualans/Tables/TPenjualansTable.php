<?php

namespace App\Filament\Resources\TPenjualans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class TPenjualansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('penjualan_kode')
                    ->label('Kode')
                    ->copyable()
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pembeli')
                    ->label('Pembeli')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.nama')
                    ->label('Kasir')
                    ->sortable(),
                TextColumn::make('penjualan_tanggal')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('total_penjualan')
                    ->label('Total')
                    ->alignEnd()
                    ->fontFamily('mono')
                    ->weight('bold'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
