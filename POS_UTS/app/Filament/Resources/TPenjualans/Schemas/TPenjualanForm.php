<?php

namespace App\Filament\Resources\TPenjualans\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Placeholder;
use App\Models\MBarang;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Carbon\Carbon;
use Filament\Schemas\Schema;

class TPenjualanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Penjualan')
                    ->schema([
                        TextInput::make('penjualan_kode')
                            ->disabled()
                            ->dehydrated()
                            ->default(function () {
                                $today = Carbon::now();
                                return 'TRX-' . $today->format('Ymd') . '-TEMP';
                            })
                            ->label('Kode Penjualan'),
                        Select::make('user_id')
                            ->relationship('user', 'nama')
                            ->searchable()
                            ->required()
                            ->label('Kasir'),
                        TextInput::make('pembeli')
                            ->required()
                            ->maxLength(50)
                            ->label('Nama Pembeli'),
                        DateTimePicker::make('penjualan_tanggal')
                            ->required()
                            ->default(now())
                            ->label('Tanggal Penjualan'),
                    ])->columns(2),

                Section::make('Detail Barang')
                    ->schema([
                        Repeater::make('detail')
                            ->relationship()
                            ->schema([
                                Select::make('barang_id')
                                    ->relationship('barang', 'barang_nama')
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        $barang = MBarang::find($state);
                                        if ($barang) {
                                            $set('harga', $barang->harga_jual);
                                        }
                                    })
                                    ->label('Barang'),
                                TextInput::make('harga')
                                    ->numeric()
                                    ->required()
                                    ->prefix('Rp')
                                    ->label('Harga'),
                                TextInput::make('jumlah')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->live()
                                    ->label('Jumlah'),
                                Placeholder::make('subtotal')
                                    ->label('Subtotal')
                                    ->content(function (Get $get) {
                                        $harga = (int) $get('harga');
                                        $jumlah = (int) $get('jumlah');
                                        return 'Rp ' . number_format($harga * $jumlah, 0, ',', '.');
                                    }),
                            ])
                            ->columns(4)
                            ->label('Item Belanja'),
                    ]),
            ]);
    }
}
