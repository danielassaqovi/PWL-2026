<?php

namespace App\Filament\Resources\MBarangs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MBarangInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Status Inventori')
                    ->schema([
                        TextEntry::make('total_stok')
                            ->label('Total Stok Tersedia')
                            ->weight('bold')
                            ->size('lg')
                            ->color(fn ($state) => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger'))
                            ->suffix(' unit'),
                    ]),

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
                                        TextEntry::make('harga_beli_formatted')
                                            ->label('Harga Beli'),
                                        TextEntry::make('harga_jual_formatted')
                                            ->label('Harga Jual'),
                                    ]),
                            ]),
                        Tab::make('Riwayat Mutasi Stok')
                            ->schema([
                                RepeatableEntry::make('stok')
                                    ->schema([
                                        Grid::make(4)
                                            ->schema([
                                                TextEntry::make('stok_tanggal')
                                                    ->dateTime()
                                                    ->label('Tanggal'),
                                                TextEntry::make('stok_jumlah')
                                                    ->badge()
                                                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger')
                                                    ->label('Jumlah'),
                                                TextEntry::make('keterangan')
                                                    ->label('Alasan')
                                                    ->placeholder('Stok Masuk'),
                                                TextEntry::make('user.nama')
                                                    ->label('Petugas'),
                                                TextEntry::make('catatan_tambahan')
                                                    ->label('Catatan')
                                                    ->columnSpanFull()
                                                    ->placeholder('Tidak ada catatan tambahan'),
                                            ]),
                                    ])
                                    ->label('Log Perubahan Stok (Rusak/Hilang/Masuk)'),
                            ]),
                        Tab::make('Riwayat Penjualan')
                            ->schema([
                                RepeatableEntry::make('penjualan_detail')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextEntry::make('penjualan.penjualan_kode')
                                                    ->label('No. Nota'),
                                                TextEntry::make('jumlah')
                                                    ->label('Terjual'),
                                                TextEntry::make('penjualan.penjualan_tanggal')
                                                    ->dateTime()
                                                    ->label('Tanggal Transaksi'),
                                            ]),
                                    ])
                                    ->label('Berdasarkan Transaksi Kasir'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
