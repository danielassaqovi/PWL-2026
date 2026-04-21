<?php

namespace App\Filament\Resources\TStoks;

use App\Filament\Resources\TStoks\Pages\CreateTStok;
use App\Filament\Resources\TStoks\Pages\EditTStok;
use App\Filament\Resources\TStoks\Pages\ListTStoks;
use App\Filament\Resources\TStoks\Schemas\TStokForm;
use App\Filament\Resources\TStoks\Tables\TStoksTable;
use App\Models\TStok;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TStokResource extends Resource
{
    protected static string | \UnitEnum | null $navigationGroup = 'Transaksi';
    
    protected static ?string $label = 'Stok';
    
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cube';

    public static function form(Schema $schema): Schema
    {
        return TStokForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TStoksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTStoks::route('/'),
            'create' => CreateTStok::route('/create'),
            'edit' => EditTStok::route('/{record}/edit'),
        ];
    }
}
