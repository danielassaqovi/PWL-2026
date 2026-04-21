<?php

namespace App\Filament\Resources\Stoks;

use App\Filament\Resources\Stoks\Pages\CreateStok;
use App\Filament\Resources\Stoks\Pages\EditStok;
use App\Filament\Resources\Stoks\Pages\ListStoks;
use App\Models\Stok;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StokResource extends Resource
{
    protected static ?string $model = Stok::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon  = 'heroicon-o-archive-box';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $modelLabel      = 'Stok Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'supplier_nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('barang_id')
                    ->label('Barang')
                    ->relationship('barang', 'barang_nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('user_id')
                    ->label('Petugas')
                    ->relationship('user', 'nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\DateTimePicker::make('stok_tanggal')
                    ->label('Tanggal Masuk')
                    ->required()
                    ->default(now()),
                Forms\Components\TextInput::make('stok_jumlah')
                    ->label('Jumlah Stok')
                    ->required()
                    ->numeric()
                    ->minValue(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('stok_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier.supplier_nama')
                    ->label('Supplier')
                    ->searchable(),
                Tables\Columns\TextColumn::make('barang.barang_nama')
                    ->label('Barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.nama')
                    ->label('Petugas'),
                Tables\Columns\TextColumn::make('stok_jumlah')
                    ->label('Jumlah')
                    ->badge()
                    ->color(fn (int $state) => match (true) {
                        $state < 10  => 'danger',
                        $state <= 50 => 'warning',
                        default      => 'success',
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'supplier_nama'),
                Tables\Filters\Filter::make('stok_tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')->label('Dari'),
                        Forms\Components\DatePicker::make('sampai_tanggal')->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn ($q, $v) => $q->whereDate('stok_tanggal', '>=', $v))
                            ->when($data['sampai_tanggal'], fn ($q, $v) => $q->whereDate('stok_tanggal', '<=', $v));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => ListStoks::route('/'),
            'create' => CreateStok::route('/create'),
            'edit' => EditStok::route('/{record}/edit'),
        ];
    }
}
