<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StockChartWidget extends ChartWidget
{
    protected ?string $heading = 'Daily Stock Additions (Last 30 Days)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = DB::table('t_stok')
            ->select(
                DB::raw('DATE(stok_tanggal) as date'),
                DB::raw('SUM(stok_jumlah) as total_stock')
            )
            ->where('stok_tanggal', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Units Added',
                    'data' => $data->pluck('total_stock')->toArray(),
                    'backgroundColor' => '#10b981',
                ],
            ],
            'labels' => $data->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('M d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
