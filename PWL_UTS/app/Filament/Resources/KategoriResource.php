<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriResource\Pages;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return 'Kategori Barang';
    }

    public static function getModelLabel(): string
    {
        return 'Kategori Barang';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kategori Barang';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Informasi Kategori')
                    ->description('Isi data kategori barang dengan lengkap.')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Forms\Components\TextInput::make('kategori_kode')
                            ->label('Kode Kategori')
                            ->required()
                            ->maxLength(10)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: ELK')
                            ->prefixIcon('heroicon-o-tag'),

                        Forms\Components\TextInput::make('kategori_nama')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: Elektronik')
                            ->prefixIcon('heroicon-o-folder-open'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategori_id')
                    ->label('No.')
                    ->rowIndex()
                    ->width('60px'),

                Tables\Columns\TextColumn::make('kategori_kode')
                    ->label('Kode Kategori')
                    ->badge()
                    ->color('success')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori_nama')
                    ->label('Nama Kategori')
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
                            ->title('Kategori berhasil diperbarui.')
                    ),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Kategori berhasil dihapus.')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('kategori_id', 'asc')
            ->striped()
            ->emptyStateHeading('Belum ada data kategori')
            ->emptyStateDescription('Klik tombol "Tambah Kategori Barang" untuk menambahkan data baru.')
            ->emptyStateIcon('heroicon-o-tag');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKategoris::route('/'),
            'create' => Pages\CreateKategori::route('/create'),
            'edit'   => Pages\EditKategori::route('/{record}/edit'),
        ];
    }
}
