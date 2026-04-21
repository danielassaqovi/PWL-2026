<?php

namespace App\Filament\Resources\MSuppliers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MSupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Supplier')
                    ->description('Data utama supplier')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('supplier_kode')
                                    ->required()
                                    ->maxLength(10)
                                    ->unique(ignorable: fn ($record) => $record)
                                    ->label('Kode Supplier'),
                                TextInput::make('supplier_nama')
                                    ->required()
                                    ->maxLength(100)
                                    ->label('Nama Supplier'),
                            ]),
                    ]),
                Section::make('Detail Kontak')
                    ->schema([
                        Textarea::make('supplier_alamat')
                            ->required()
                            ->maxLength(255)
                            ->label('Alamat Supplier'),
                    ]),
            ]);
    }
}
