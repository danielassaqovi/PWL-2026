<?php

namespace App\Filament\Resources\MBarangs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class MBarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Select::make('kategori_id')
                            ->relationship('kategori', 'kategori_nama')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Kategori'),
                        TextInput::make('barang_kode')
                            ->required()
                            ->unique(ignorable: fn ($record) => $record)
                            ->label('Kode Barang'),
                        TextInput::make('barang_nama')
                            ->required()
                            ->label('Nama Barang'),
                        TextInput::make('harga_beli')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->label('Harga Beli'),
                        TextInput::make('harga_jual')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->label('Harga Jual')
                            ->minValue(fn (callable $get) => $get('harga_beli'))
                            ->validationMessages([
                                'min' => 'Harga jual harus lebih besar atau sama dengan harga beli.',
                            ]),
                    ]),
            ]);
    }
}
