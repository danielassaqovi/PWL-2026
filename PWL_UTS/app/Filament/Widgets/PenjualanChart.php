<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class PenjualanChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Penjualan 7 Hari Terakhir';

    protected function getData(): array
    {
        $data = collect(range(6, 0))->map(function ($daysAgo) {
            $date  = now()->subDays($daysAgo);
            $total = \App\Models\PenjualanDetail::whereHas('penjualan', fn($q) =>
                $q->whereDate('penjualan_tanggal', $date)
            )->sum(\DB::raw('harga * jumlah'));

            return ['date' => $date->format('d/m'), 'total' => $total];
        });

        return [
            'datasets' => [[
                'label'           => 'Pendapatan (Rp)',
                'data'            => $data->pluck('total')->toArray(),
                'backgroundColor' => '#6366f1',
                'borderColor'     => '#6366f1',
            ]],
            'labels' => $data->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
