<?php

namespace App\Filament\Resources\Penjualans;

use App\Filament\Resources\Penjualans\Pages\CreatePenjualan;
use App\Filament\Resources\Penjualans\Pages\EditPenjualan;
use App\Filament\Resources\Penjualans\Pages\ListPenjualans;
use App\Models\Penjualan;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Transaksi';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Penjualan';

    protected static ?string $recordTitleAttribute = 'penjualan_kode';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Informasi Penjualan')
                    ->schema([
                        Forms\Components\TextInput::make('penjualan_kode')
                            ->label('Kode Transaksi')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->default('TRX-' . now()->format('Ymd') . '-' . strtoupper(\Str::random(4))),
                        Forms\Components\TextInput::make('pembeli')
                            ->label('Nama Pembeli')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\Select::make('user_id')
                            ->label('Kasir')
                            ->relationship('user', 'nama')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\DateTimePicker::make('penjualan_tanggal')
                            ->label('Tanggal Transaksi')
                            ->required()
                            ->default(now()),
                    ])->columns(2),

                Forms\Components\Section::make('Detail Barang')
                    ->schema([
                        Forms\Components\Repeater::make('detail')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('barang_id')
                                    ->label('Barang')
                                    ->options(\App\Models\Barang::pluck('barang_nama', 'barang_id'))
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $barang = \App\Models\Barang::find($state);
                                        $set('harga', $barang?->harga_jual ?? 0);
                                    }),
                                Forms\Components\TextInput::make('harga')
                                    ->label('Harga Satuan')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                                Forms\Components\TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->default(1),
                            ])->columns(3)
                            ->addActionLabel('+ Tambah Barang')
                            ->minItems(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('penjualan_kode')
                    ->label('Kode Transaksi')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('pembeli')
                    ->label('Pembeli')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.nama')
                    ->label('Kasir'),
                Tables\Columns\TextColumn::make('penjualan_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('detail_count')
                    ->label('Jml Item')
                    ->counts('detail')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total')
                    ->money('IDR')
                    ->getStateUsing(fn ($record) => 
                        $record->detail->sum(fn ($d) => $d->harga * $d->jumlah)
                    )
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading('Detail Transaksi')
                    ->modalContent(fn ($record) => view(
                        'filament.pages.penjualan-detail', 
                        ['penjualan' => $record->load('detail.barang')]
                    )),
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
            'index' => ListPenjualans::route('/'),
            'create' => CreatePenjualan::route('/create'),
            'edit' => EditPenjualan::route('/{record}/edit'),
        ];
    }
}
