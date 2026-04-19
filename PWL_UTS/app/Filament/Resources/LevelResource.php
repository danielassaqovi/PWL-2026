<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelResource\Pages;
use App\Models\Level;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return 'Level Pengguna';
    }

    public static function getModelLabel(): string
    {
        return 'Level Pengguna';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Level Pengguna';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Informasi Level')
                    ->description('Isi data level pengguna dengan lengkap.')
                    ->icon('heroicon-o-shield-check')
                    ->schema([
                        Forms\Components\TextInput::make('level_kode')
                            ->label('Kode Level')
                            ->required()
                            ->maxLength(10)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: ADM')
                            ->prefixIcon('heroicon-o-tag'),

                        Forms\Components\TextInput::make('level_nama')
                            ->label('Nama Level')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: Administrator')
                            ->prefixIcon('heroicon-o-identification'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('level_id')
                    ->label('No.')
                    ->rowIndex()
                    ->width('60px'),

                Tables\Columns\TextColumn::make('level_kode')
                    ->label('Kode Level')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('level_nama')
                    ->label('Nama Level')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Level berhasil diperbarui.')
                    ),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Level berhasil dihapus.')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('level_id', 'asc')
            ->striped()
            ->emptyStateHeading('Belum ada data level')
            ->emptyStateDescription('Klik tombol "Tambah Level Pengguna" untuk menambahkan data baru.')
            ->emptyStateIcon('heroicon-o-shield-check');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
            'edit'   => Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}
