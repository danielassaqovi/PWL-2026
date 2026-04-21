<?php

namespace App\Filament\Resources\TPenjualans;

use App\Filament\Resources\TPenjualans\Pages\CreateTPenjualan;
use App\Filament\Resources\TPenjualans\Pages\EditTPenjualan;
use App\Filament\Resources\TPenjualans\Pages\ListTPenjualans;
use App\Filament\Resources\TPenjualans\Pages\ViewTPenjualan;
use App\Filament\Resources\TPenjualans\Schemas\TPenjualanForm;
use App\Filament\Resources\TPenjualans\Schemas\TPenjualanInfolist;
use App\Filament\Resources\TPenjualans\Tables\TPenjualansTable;
use App\Models\TPenjualan;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Actions\Action;

class TPenjualanResource extends Resource
{
    protected static string | \UnitEnum | null $navigationGroup = 'Transaksi';
    
    protected static ?string $label = 'Penjualan';
    
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $recordTitleAttribute = 'penjualan_kode';

    public static function getGloballySearchableAttributes(): array
    {
        return ['penjualan_kode', 'pembeli'];
    }

    public static function form(Schema $schema): Schema
    {
        return TPenjualanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TPenjualanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TPenjualansTable::configure($table);
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
            'index' => ListTPenjualans::route('/'),
            'create' => CreateTPenjualan::route('/create'),
            'view' => ViewTPenjualan::route('/{record}'),
            'edit' => EditTPenjualan::route('/{record}/edit'),
        ];
    }
}
