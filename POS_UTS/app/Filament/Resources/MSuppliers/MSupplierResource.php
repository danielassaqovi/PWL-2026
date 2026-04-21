<?php

namespace App\Filament\Resources\MSuppliers;

use App\Filament\Resources\MSuppliers\Pages\CreateMSupplier;
use App\Filament\Resources\MSuppliers\Pages\EditMSupplier;
use App\Filament\Resources\MSuppliers\Pages\ListMSuppliers;
use App\Filament\Resources\MSuppliers\Schemas\MSupplierForm;
use App\Filament\Resources\MSuppliers\Tables\MSuppliersTable;
use App\Models\MSupplier;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MSupplierResource extends Resource
{
    protected static string | \UnitEnum | null $navigationGroup = 'Master Data';
    
    protected static ?string $label = 'Supplier';
    
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-truck';

    public static function form(Schema $schema): Schema
    {
        return MSupplierForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MSuppliersTable::configure($table);
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
            'index' => ListMSuppliers::route('/'),
            'create' => CreateMSupplier::route('/create'),
            'edit' => EditMSupplier::route('/{record}/edit'),
        ];
    }
}
