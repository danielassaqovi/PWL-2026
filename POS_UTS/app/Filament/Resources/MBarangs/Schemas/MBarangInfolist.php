<?php

namespace App\Filament\Resources\MBarangs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class MBarangInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Barang Details')
                    ->tabs([
                        Tab::make('Informasi Barang')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('barang_kode')
                                            ->label('Kode Barang')
                                            ->badge(),
                                        TextEntry::make('barang_nama')
                                            ->label('Nama Barang'),
                                        TextEntry::make('kategori.kategori_nama')
                                            ->label('Kategori'),
                                        TextEntry::make('harga_beli')
                                            ->money('IDR', locale: 'id')
                                            ->label('Harga Beli'),
                                        TextEntry::make('harga_jual')
                                            ->money('IDR', locale: 'id')
                                            ->label('Harga Jual'),
                                    ]),
                            ]),
                        Tab::make('Riwayat Stok')
                            ->schema([
                                RepeatableEntry::make('stok')
                                    ->schema([
                                        Grid::make(4)
                                            ->schema([
                                                TextEntry::make('stok_tanggal')
                                                    ->dateTime()
                                                    ->label('Tanggal'),
                                                TextEntry::make('supplier.supplier_nama')
                                                    ->label('Supplier'),
                                                TextEntry::make('stok_jumlah')
                                                    ->badge()
                                                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger')
                                                    ->label('Jumlah'),
                                                TextEntry::make('user.nama')
                                                    ->label('Oleh'),
                                            ]),
                                    ])
                                    ->label('Log Mutasi Stok'),
                            ]),
                        Tab::make('Riwayat Penjualan')
                            ->schema([
                                RepeatableEntry::make('penjualan_detail')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextEntry::make('penjualan.penjualan_kode')
                                                    ->label('Kode Transaksi'),
                                                TextEntry::make('jumlah')
                                                    ->label('Jumlah Terjual'),
                                                TextEntry::make('penjualan.penjualan_tanggal')
                                                    ->dateTime()
                                                    ->label('Tanggal'),
                                            ]),
                                    ])
                                    ->label('Berdasarkan Transaksi'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
