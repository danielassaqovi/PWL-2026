<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-truck';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return 'Supplier';
    }

    public static function getModelLabel(): string
    {
        return 'Supplier';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Supplier';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Informasi Supplier')
                    ->description('Isi data supplier dengan lengkap dan benar.')
                    ->icon('heroicon-o-truck')
                    ->schema([
                        Forms\Components\TextInput::make('supplier_kode')
                            ->label('Kode Supplier')
                            ->required()
                            ->maxLength(10)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: SUP001')
                            ->prefixIcon('heroicon-o-tag'),

                        Forms\Components\TextInput::make('supplier_nama')
                            ->label('Nama Supplier')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: PT. Maju Bersama')
                            ->prefixIcon('heroicon-o-building-office'),

                        Forms\Components\Textarea::make('supplier_alamat')
                            ->label('Alamat Supplier')
                            ->required()
                            ->maxLength(255)
                            ->rows(3)
                            ->placeholder('Masukkan alamat lengkap supplier')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier_id')
                    ->label('No.')
                    ->rowIndex()
                    ->width('60px'),

                Tables\Columns\TextColumn::make('supplier_kode')
                    ->label('Kode Supplier')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('supplier_nama')
                    ->label('Nama Supplier')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('supplier_alamat')
                    ->label('Alamat')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->supplier_alamat),
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
                            ->title('Supplier berhasil diperbarui.')
                    ),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Supplier berhasil dihapus.')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('supplier_id', 'asc')
            ->striped()
            ->emptyStateHeading('Belum ada data supplier')
            ->emptyStateDescription('Klik tombol "Tambah Supplier" untuk menambahkan data baru.')
            ->emptyStateIcon('heroicon-o-truck');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit'   => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}
