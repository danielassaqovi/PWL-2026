<?php

namespace App\Filament\Resources\Suppliers;

use App\Filament\Resources\Suppliers\Pages;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Data';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-truck';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Supplier';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('supplier_kode')
                    ->label('Kode Supplier')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('supplier_nama')
                    ->label('Nama Supplier')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Textarea::make('supplier_alamat')
                    ->label('Alamat')
                    ->required()
                    ->maxLength(255)
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier_kode')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier_nama')
                    ->label('Nama Supplier')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier_alamat')
                    ->label('Alamat')
                    ->limit(50)
                    ->tooltip(fn (Supplier $record): string => $record->supplier_alamat),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
