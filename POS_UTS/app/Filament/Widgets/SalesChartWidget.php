<?php

namespace App\Filament\Widgets;

use App\Models\TPenjualan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SalesChartWidget extends ChartWidget
{
    protected ?string $heading = 'Daily Revenue (Last 30 Days)';
    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $data = DB::table('t_penjualan')
            ->join('t_penjualan_detail', 't_penjualan.penjualan_id', '=', 't_penjualan_detail.penjualan_id')
            ->select(
                DB::raw('DATE(penjualan_tanggal) as date'),
                DB::raw('SUM(harga * jumlah) as revenue')
            )
            ->where('penjualan_tanggal', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data->pluck('revenue')->toArray(),
                    'borderColor' => '#6366f1',
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('M d'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
