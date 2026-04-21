<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users   = \App\Models\MUser::all();
        $barangs = \App\Models\Barang::all();

        $transaksi = [
            ['Andi Prasetyo',   -6, [['BRG001',2],['BRG004',3]]],
            ['Budi Hartono',    -6, [['BRG002',1],['BRG005',2],['BRG007',1]]],
            ['Citra Dewi',      -5, [['BRG003',2],['BRG006',1]]],
            ['Deni Kurniawan',  -5, [['BRG008',3],['BRG009',1]]],
            ['Eka Wulandari',   -4, [['BRG010',2],['BRG011',5]]],
            ['Fajar Nugroho',   -4, [['BRG001',4],['BRG004',2],['BRG012',3]]],
            ['Gita Pramesti',   -3, [['BRG002',2],['BRG005',1]]],
            ['Hendra Wijaya',   -2, [['BRG003',1],['BRG006',3],['BRG007',2]]],
            ['Indah Sari',      -1, [['BRG009',1],['BRG010',1]]],
            ['Joko Santoso',     0, [['BRG001',3],['BRG004',4],['BRG011',2]]],
        ];

        foreach ($transaksi as $idx => [$pembeli, $dayOffset, $items]) {
            $tanggal  = now()->addDays($dayOffset);
            $kode     = 'TRX-' . $tanggal->format('Ymd') . '-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT);
            $user     = $users[$idx % $users->count()];

            $penjualan = \App\Models\Penjualan::create([
                'user_id'           => $user->user_id,
                'pembeli'           => $pembeli,
                'penjualan_kode'    => $kode,
                'penjualan_tanggal' => $tanggal,
            ]);

            foreach ($items as [$brngKode, $jumlah]) {
                $barang = $barangs->where('barang_kode', $brngKode)->first();
                if ($barang) {
                    \App\Models\PenjualanDetail::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id'    => $barang->barang_id,
                        'harga'        => $barang->harga_jual,
                        'jumlah'       => $jumlah,
                    ]);
                }
            }
        }
    }
}
