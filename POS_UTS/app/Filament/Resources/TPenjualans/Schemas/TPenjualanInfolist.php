<?php

namespace App\Filament\Resources\TPenjualans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class TPenjualanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Details')
                    ->tabs([
                        Tab::make('Informasi Transaksi')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('penjualan_kode')
                                            ->badge()
                                            ->copyable()
                                            ->label('Kode Penjualan'),
                                        TextEntry::make('pembeli')
                                            ->label('Nama Pembeli'),
                                        TextEntry::make('penjualan_tanggal')
                                            ->dateTime()
                                            ->label('Tanggal'),
                                        TextEntry::make('user.nama')
                                            ->label('Kasir'),
                                    ]),
                            ]),
                        Tab::make('Detail Barang')
                            ->schema([
                                RepeatableEntry::make('detail')
                                    ->schema([
                                        Grid::make(5)
                                            ->schema([
                                                TextEntry::make('barang.barang_kode')
                                                    ->label('Kode'),
                                                TextEntry::make('barang.barang_nama')
                                                    ->label('Barang'),
                                                TextEntry::make('harga')
                                                    ->money('IDR', locale: 'id')
                                                    ->label('Harga'),
                                                TextEntry::make('jumlah')
                                                    ->label('Qty'),
                                                TextEntry::make('subtotal')
                                                    ->state(fn ($record) => $record->harga * $record->jumlah)
                                                    ->money('IDR', locale: 'id')
                                                    ->weight('bold')
                                                    ->label('Subtotal'),
                                            ]),
                                    ])
                                    ->label('Item Terjual'),
                            ]),
                        Tab::make('Ringkasan')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('total_item')
                                            ->state(fn ($record) => $record->detail->count() . ' Item')
                                            ->label('Total Item'),
                                        TextEntry::make('total_penjualan')
                                            ->label('Total Penjualan')
                                            ->size('xl')
                                            ->weight('bold')
                                            ->color('primary'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
