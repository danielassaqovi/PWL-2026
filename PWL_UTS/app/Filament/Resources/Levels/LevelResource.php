<?php

namespace App\Filament\Resources\Levels;

use App\Filament\Resources\Levels\Pages;
use App\Models\Level;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Data';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-check';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Level Pengguna';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('level_kode')
                    ->label('Kode Level')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('level_nama')
                    ->label('Nama Level')
                    ->required()
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('level_kode')
                    ->label('Kode Level')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level_nama')
                    ->label('Nama Level')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Administrator' => 'primary',
                        'Manajer' => 'success',
                        'Kasir' => 'warning',
                        default => 'gray',
                    }),
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
            'index' => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
            'edit' => Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}
