<?php

namespace App\Filament\Resources\MKategoris\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MKategoriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kategori_kode')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignorable: fn ($record) => $record)
                    ->label('Kode Kategori'),
                TextInput::make('kategori_nama')
                    ->required()
                    ->maxLength(100)
                    ->minLength(3)
                    ->label('Nama Kategori'),
            ]);
    }
}
