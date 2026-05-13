<?php

namespace App\Filament\Pages;

use App\Models\MBarang;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class MonitoringStok extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected string $view = 'filament.pages.monitoring-stok';

    protected static ?string $title = 'Monitoring Stok';

    protected static ?string $navigationLabel = 'Monitoring Stok';

    protected static string | \UnitEnum | null $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(MBarang::query())
            ->columns([
                TextColumn::make('barang_kode')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('barang_nama')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kategori.kategori_nama')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('total_stok')
                    ->label('Sisa Stok')
                    ->suffix(' unit')
                    ->weight('bold')
                    ->badge()
                    ->color(fn ($state) => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger'))
                    ->sortable(false),
                TextColumn::make('harga_jual')
                    ->label('Harga Jual')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
            ])
            ->actions([
                \Filament\Actions\Action::make('Detail')
                    ->icon('heroicon-m-eye')
                    ->url(fn (MBarang $record): string => route('filament.admin.resources.m-barangs.view', $record)),
            ]);
    }
}
