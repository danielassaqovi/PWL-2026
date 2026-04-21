<?php

namespace App\Filament\Resources\MKategoris;

use App\Filament\Resources\MKategoris\Pages\CreateMKategori;
use App\Filament\Resources\MKategoris\Pages\EditMKategori;
use App\Filament\Resources\MKategoris\Pages\ListMKategoris;
use App\Filament\Resources\MKategoris\Schemas\MKategoriForm;
use App\Filament\Resources\MKategoris\Tables\MKategorisTable;
use App\Models\MKategori;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MKategoriResource extends Resource
{
    protected static string | \UnitEnum | null $navigationGroup = 'Master Data';
    
    protected static ?string $label = 'Kategori';
    
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    public static function form(Schema $schema): Schema
    {
        return MKategoriForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MKategorisTable::configure($table);
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
            'index' => ListMKategoris::route('/'),
            'create' => CreateMKategori::route('/create'),
            'edit' => EditMKategori::route('/{record}/edit'),
        ];
    }
}
