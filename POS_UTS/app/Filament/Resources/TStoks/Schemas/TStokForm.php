<?php

namespace App\Filament\Resources\TStoks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class TStokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Stok')
                    ->description('Catat penambahan atau pengurangan stok barang di sini.')
                    ->schema([
                        Select::make('barang_id')
                            ->relationship('barang', 'barang_nama')
                            ->searchable()
                            ->required()
                            ->label('Barang'),
                        
                        Select::make('supplier_id')
                            ->relationship('supplier', 'supplier_nama')
                            ->searchable()
                            ->nullable()
                            ->placeholder('Pilih supplier jika barang masuk')
                            ->label('Supplier (Opsional)'),

                        DateTimePicker::make('stok_tanggal')
                            ->required()
                            ->default(now())
                            ->label('Tanggal'),

                        TextInput::make('stok_jumlah')
                            ->numeric()
                            ->required()
                            ->helperText('Gunakan angka negatif (misal: -5) untuk mencatat barang rusak, hilang, atau kadaluarsa.')
                            ->label('Jumlah Perubahan Stok'),

                        Select::make('keterangan')
                            ->options([
                                'Barang Masuk' => 'Barang Masuk (Stock In)',
                                'Barang Rusak' => 'Barang Rusak',
                                'Barang Kadaluarsa' => 'Barang Kadaluarsa',
                                'Barang Hilang' => 'Barang Hilang',
                                'Retur' => 'Retur Barang',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->label('Alasan/Keterangan'),

                        Textarea::make('catatan_tambahan')
                            ->placeholder('Tambahkan detail jika perlu...')
                            ->label('Catatan Tambahan')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
