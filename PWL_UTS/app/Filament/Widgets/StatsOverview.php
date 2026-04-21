<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalBarang    = \App\Models\Barang::count();
        $totalSupplier  = \App\Models\Supplier::count();
        $penjualanHariIni = \App\Models\Penjualan::whereDate('penjualan_tanggal', today())->count();
        $pendapatanHariIni = \App\Models\PenjualanDetail::whereHas('penjualan', fn($q) =>
            $q->whereDate('penjualan_tanggal', today())
        )->sum(\DB::raw('harga * jumlah'));

        return [
            Stat::make('Total Barang', $totalBarang)
                ->description('Barang terdaftar')
                ->icon('heroicon-o-cube')
                ->color('primary'),
            Stat::make('Total Supplier', $totalSupplier)
                ->description('Supplier aktif')
                ->icon('heroicon-o-truck')
                ->color('info'),
            Stat::make('Penjualan Hari Ini', $penjualanHariIni . ' transaksi')
                ->description('Total transaksi hari ini')
                ->icon('heroicon-o-shopping-cart')
                ->color('success'),
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($pendapatanHariIni,0,',','.'))
                ->description('Total pendapatan hari ini')
                ->icon('heroicon-o-currency-dollar')
                ->color('warning'),
        ];
    }
}
