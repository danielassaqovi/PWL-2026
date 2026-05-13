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
                                        Grid::make(6)
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
                                                TextEntry::make('sisa_stok')
                                                    ->state(function ($record) {
                                                        $barangId = $record->barang_id;
                                                        $penjualanTanggal = $record->penjualan->penjualan_tanggal;
                                                        $penjualanId = $record->penjualan_id;

                                                        // Sum all stock IN until this sale date
                                                        $stokMasuk = \App\Models\TStok::where('barang_id', $barangId)
                                                            ->where('stok_tanggal', '<=', $penjualanTanggal)
                                                            ->sum('stok_jumlah');

                                                        // Sum all sales OUT until this sale date/id
                                                        // We use both date and ID to ensure a stable ordering if dates are identical
                                                        $stokKeluar = \App\Models\TPenjualanDetail::where('barang_id', $barangId)
                                                            ->whereHas('penjualan', function ($query) use ($penjualanTanggal, $penjualanId) {
                                                                $query->where('penjualan_tanggal', '<', $penjualanTanggal)
                                                                    ->orWhere(function ($q) use ($penjualanTanggal, $penjualanId) {
                                                                        $q->where('penjualan_tanggal', $penjualanTanggal)
                                                                          ->where('penjualan_id', '<=', $penjualanId);
                                                                    });
                                                            })
                                                            ->sum('jumlah');

                                                        return ($stokMasuk - $stokKeluar) . ' unit';
                                                    })
                                                    ->color('danger')
                                                    ->weight('bold')
                                                    ->label('Sisa Stok'),
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
