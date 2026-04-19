<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Models\Barang;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 4;

    public static function getNavigationLabel(): string
    {
        return 'Barang';
    }

    public static function getModelLabel(): string
    {
        return 'Barang';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Barang';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Informasi Barang')
                    ->description('Isi data barang dengan lengkap dan benar.')
                    ->icon('heroicon-o-cube')
                    ->schema([
                        Forms\Components\TextInput::make('barang_kode')
                            ->label('Kode Barang')
                            ->required()
                            ->maxLength(10)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: BRG001')
                            ->prefixIcon('heroicon-o-tag'),

                        Forms\Components\TextInput::make('barang_nama')
                            ->label('Nama Barang')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: Laptop ASUS VivoBook')
                            ->prefixIcon('heroicon-o-cube'),

                        Forms\Components\Select::make('kategori_id')
                            ->label('Kategori')
                            ->options(Kategori::query()->pluck('kategori_nama', 'kategori_id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih kategori barang'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Harga')
                    ->description('Masukkan harga beli dan harga jual barang.')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Forms\Components\TextInput::make('harga_beli')
                            ->label('Harga Beli')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('0')
                            ->minValue(0),

                        Forms\Components\TextInput::make('harga_jual')
                            ->label('Harga Jual')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('0')
                            ->minValue(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('barang_id')
                    ->label('No.')
                    ->rowIndex()
                    ->width('60px'),

                Tables\Columns\TextColumn::make('barang_kode')
                    ->label('Kode Barang')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('barang_nama')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('kategori.kategori_nama')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn ($record) => match ($record->kategori_id % 5) {
                        0 => 'primary',
                        1 => 'success',
                        2 => 'warning',
                        3 => 'danger',
                        default => 'info',
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga_beli')
                    ->label('Harga Beli')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga_jual')
                    ->label('Harga Jual')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->options(Kategori::query()->pluck('kategori_nama', 'kategori_id'))
                    ->placeholder('Semua Kategori'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Barang berhasil diperbarui.')
                    ),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Barang berhasil dihapus.')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('barang_id', 'asc')
            ->striped()
            ->emptyStateHeading('Belum ada data barang')
            ->emptyStateDescription('Klik tombol "Tambah Barang" untuk menambahkan data baru.')
            ->emptyStateIcon('heroicon-o-cube');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit'   => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
