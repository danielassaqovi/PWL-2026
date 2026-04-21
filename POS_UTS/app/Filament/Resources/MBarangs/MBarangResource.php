<?php

namespace App\Filament\Resources\MBarangs;

use App\Filament\Resources\MBarangs\Pages\CreateMBarang;
use App\Filament\Resources\MBarangs\Pages\EditMBarang;
use App\Filament\Resources\MBarangs\Pages\ListMBarangs;
use App\Filament\Resources\MBarangs\Pages\ViewMBarang;
use App\Filament\Resources\MBarangs\Schemas\MBarangForm;
use App\Filament\Resources\MBarangs\Schemas\MBarangInfolist;
use App\Filament\Resources\MBarangs\Tables\MBarangsTable;
use App\Models\MBarang;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MBarangResource extends Resource
{
    protected static string | \UnitEnum | null $navigationGroup = 'Master Data';
    
    protected static ?string $label = 'Barang';
    
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-archive-box';
    
    protected static ?string $recordTitleAttribute = 'barang_nama';

    public static function getGloballySearchableAttributes(): array
    {
        return ['barang_kode', 'barang_nama'];
    }

    public static function form(Schema $schema): Schema
    {
        return MBarangForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MBarangInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MBarangsTable::configure($table);
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
            'index' => ListMBarangs::route('/'),
            'create' => CreateMBarang::route('/create'),
            'view' => ViewMBarang::route('/{record}'),
            'edit' => EditMBarang::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
