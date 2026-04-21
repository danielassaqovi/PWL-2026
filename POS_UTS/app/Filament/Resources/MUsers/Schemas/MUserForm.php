<?php

namespace App\Filament\Resources\MUsers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class MUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('level_id')
                    ->relationship('level', 'level_nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Level'),
                TextInput::make('username')
                    ->required()
                    ->unique(ignorable: fn ($record) => $record)
                    ->maxLength(20)
                    ->label('Username'),
                TextInput::make('nama')
                    ->required()
                    ->maxLength(100)
                    ->label('Nama'),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->label('Password'),
            ]);
    }
}
