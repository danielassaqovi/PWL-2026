<?php

namespace App\Filament\Resources\Stoks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('supplier_id')
                    ->relationship('supplier', 'supplier_id')
                    ->required(),
                Select::make('barang_id')
                    ->relationship('barang', 'barang_id')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'user_id')
                    ->required(),
                DateTimePicker::make('stok_tanggal')
                    ->required(),
                TextInput::make('stok_jumlah')
                    ->required()
                    ->numeric(),
            ]);
    }
}
