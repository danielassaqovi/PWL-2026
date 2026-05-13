<?php

namespace App\Filament\Resources\TPenjualans\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Grid;
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
                    ->description('Informasi utama transaksi')
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
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Detail Barang')
                    ->description('Daftar item yang dibeli')
                    ->schema([
                        Repeater::make('detail')
                            ->relationship()
                            ->schema([
                                Grid::make(12)
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
                                            ->label('Barang')
                                            ->columnSpan(5),
                                        TextInput::make('harga')
                                            ->numeric()
                                            ->required()
                                            ->prefix('Rp')
                                            ->label('Harga')
                                            ->columnSpan(3),
                                        TextInput::make('jumlah')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->minValue(1)
                                            ->live()
                                            ->helperText(function (Get $get) {
                                                $barangId = $get('barang_id');
                                                if (!$barangId) return null;

                                                $stokMasuk = \App\Models\TStok::where('barang_id', $barangId)->sum('stok_jumlah');
                                                // Gunakan withTrashed agar stok yang dihapus tetap terhitung sebagai stok keluar
                                                $stokKeluar = \App\Models\TPenjualanDetail::withTrashed()
                                                    ->where('barang_id', $barangId)
                                                    ->when($get('../../penjualan_id'), function($query) use ($get) {
                                                        $query->where('penjualan_id', '!=', $get('../../penjualan_id'));
                                                    })
                                                    ->sum('jumlah');

                                                $stokTersedia = $stokMasuk - $stokKeluar;
                                                return "Tersedia: {$stokTersedia}";
                                            })
                                            ->rules([
                                                fn (Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                                    $barangId = $get('barang_id');
                                                    if (!$barangId) return;

                                                    $stokMasuk = \App\Models\TStok::where('barang_id', $barangId)->sum('stok_jumlah');
                                                    // Gunakan withTrashed agar stok yang dihapus tetap terhitung sebagai stok keluar
                                                    $stokKeluar = \App\Models\TPenjualanDetail::withTrashed()
                                                        ->where('barang_id', $barangId)
                                                        ->when($get('../../penjualan_id'), function($query) use ($get) {
                                                            $query->where('penjualan_id', '!=', $get('../../penjualan_id'));
                                                        })
                                                        ->sum('jumlah');

                                                    $stokTersedia = $stokMasuk - $stokKeluar;

                                                    if ($value > $stokTersedia) {
                                                        $fail("Stok tidak mencukupi. Sisa: {$stokTersedia}");
                                                    }
                                                },
                                            ])
                                            ->label('Qty')
                                            ->columnSpan(2),
                                        Placeholder::make('subtotal')
                                            ->label('Subtotal')
                                            ->content(function (Get $get) {
                                                $harga = (int) $get('harga');
                                                $jumlah = (int) $get('jumlah');
                                                return 'Rp ' . number_format($harga * $jumlah, 0, ',', '.');
                                            })
                                            ->columnSpan(2),
                                    ]),
                            ])
                            ->label('Item Belanja')
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Barang')
                            ->collapsible()
                            ->cloneable(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
