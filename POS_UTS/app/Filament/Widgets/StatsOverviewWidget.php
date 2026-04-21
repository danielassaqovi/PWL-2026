<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $totalRevenue = DB::table('t_penjualan_detail')->sum(DB::raw('harga * jumlah'));
        $totalTransactions = DB::table('t_penjualan')->count();
        $totalItemsSold = DB::table('t_penjualan_detail')->sum('jumlah');

        return [
            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Overall revenue from all time')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            Stat::make('Total Transactions', number_format($totalTransactions, 0, ',', '.'))
                ->description('Total number of sales')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
            Stat::make('Items Sold', number_format($totalItemsSold, 0, ',', '.'))
                ->description('Total number of units sold')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('warning'),
        ];
    }
}
