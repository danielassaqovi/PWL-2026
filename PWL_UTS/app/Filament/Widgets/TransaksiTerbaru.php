<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use no;

class TransaksiTerbaru extends TableWidget
{
    protected static ?string $heading = '5 Transaksi Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\Penjualan::with('detail')
                    ->latest('penjualan_tanggal')
                    ->limit(5)
            )
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('penjualan_kode')->label('Kode'),
                \Filament\Tables\Columns\TextColumn::make('pembeli')->label('Pembeli'),
                \Filament\Tables\Columns\TextColumn::make('penjualan_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i'),
                \Filament\Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->getStateUsing(fn ($r) => 'Rp ' . number_format(
                        $r->detail->sum(fn($d) => $d->harga * $d->jumlah), 0, ',', '.'
                    )),
            ])
            ->paginated(false);
    }
}
