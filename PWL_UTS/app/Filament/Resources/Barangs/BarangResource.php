<?php

namespace App\Filament\Resources\Barangs;

use App\Filament\Resources\Barangs\Pages;
use App\Models\Barang;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Data';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cube';
    protected static ?int    $navigationSort = 4;
    protected static ?string $modelLabel = 'Barang';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'kategori_nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('barang_kode')
                    ->label('Kode Barang')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('barang_nama')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('harga_beli')
                    ->label('Harga Beli')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0),
                Forms\Components\TextInput::make('harga_jual')
                    ->label('Harga Jual')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('barang_kode')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('barang_nama')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori.kategori_nama')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('harga_beli')
                    ->label('Harga Beli')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga_jual')
                    ->label('Harga Jual')
                    ->money('IDR')
                    ->sortable(),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
