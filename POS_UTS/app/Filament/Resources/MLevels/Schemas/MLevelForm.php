<?php

namespace App\Filament\Resources\MLevels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MLevelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('level_kode')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignorable: fn ($record) => $record)
                    ->label('Kode Level'),
                TextInput::make('level_nama')
                    ->required()
                    ->maxLength(100)
                    ->label('Nama Level'),
            ]);
    }
}
