<?php

namespace App\Filament\Resources\MUsers;

use App\Filament\Resources\MUsers\Pages;
use App\Models\MUser;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MUserResource extends Resource
{
    protected static ?string $model = MUser::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Master Data';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';
    protected static ?int    $navigationSort = 5;
    protected static ?string $modelLabel = 'Pengguna';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('level_id')
                    ->label('Level')
                    ->relationship('level', 'level_nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level.level_nama')
                    ->label('Level')
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
            'index' => Pages\ListMUsers::route('/'),
            'create' => Pages\CreateMUser::route('/create'),
            'edit' => Pages\EditMUser::route('/{record}/edit'),
        ];
    }
}
