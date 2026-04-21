<?php

namespace App\Filament\Resources\TStoks\Schemas;

use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use App\Models\MBarang;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TStokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Pilih Barang & Supplier')
                        ->schema([
                            Select::make('supplier_id')
                                ->relationship('supplier', 'supplier_nama')
                                ->searchable()
                                ->required()
                                ->label('Supplier'),
                            Select::make('barang_id')
                                ->relationship('barang', 'barang_nama')
                                ->searchable()
                                ->required()
                                ->live()
                                ->label('Barang'),
                            Placeholder::make('info_stok')
                                ->label('Stok Saat Ini')
                                ->content(function (Get $get) {
                                    $barangId = $get('barang_id');
                                    if (!$barangId) return '-';
                                    $barang = MBarang::find($barangId);
                                    if (!$barang) return '-';
                                    $currentStok = $barang->stok()->sum('stok_jumlah');
                                    return $currentStok . ' unit';
                                }),
                        ]),
                    Step::make('Detail Stok')
                        ->schema([
                             DateTimePicker::make('stok_tanggal')
                                 ->required()
                                 ->default(now())
                                 ->label('Tanggal Stok'),
                             TextInput::make('stok_jumlah')
                                 ->numeric()
                                 ->required()
                                 ->minValue(1)
                                 ->label('Jumlah Stok'),
                             Placeholder::make('harga_beli_info')
                                 ->label('Harga Beli Master')
                                 ->content(function (Get $get) {
                                     $barangId = $get('barang_id');
                                     if (!$barangId) return '-';
                                     $barang = MBarang::find($barangId);
                                     return $barang ? 'Rp ' . number_format($barang->harga_beli, 0, ',', '.') : '-';
                                 }),
                         ]),
                    Step::make('Konfirmasi')
                        ->schema([
                            Placeholder::make('summary')
                                ->label('Ringkasan Data')
                                ->content('Silakan tinjau kembali data di atas sebelum menekan tombol Simpan.'),
                        ]),
                ])
                ->columnSpanFull(),
            ]);
    }
}
