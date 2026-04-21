<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplier = \App\Models\Supplier::all();
        $barang   = \App\Models\Barang::all();
        $user     = \App\Models\MUser::all();

        $data = [
            [0, 0, 0, 100, -15], [1, 1, 1, 50,  -12],
            [2, 2, 0, 75,   -9], [3, 3, 1, 60,   -7],
            [4, 4, 0, 80,   -5], [0, 5, 1, 45,   -4],
            [1, 6, 0, 90,   -3], [2, 7, 1, 55,   -2],
            [3, 8, 0, 70,   -1], [4, 9, 1, 65,    0],
        ];

        foreach ($data as [$supIdx, $brngIdx, $usrIdx, $jumlah, $dayOffset]) {
            \App\Models\Stok::create([
                'supplier_id'  => $supplier[$supIdx % $supplier->count()]->supplier_id,
                'barang_id'    => $barang[$brngIdx % $barang->count()]->barang_id,
                'user_id'      => $user[$usrIdx % $user->count()]->user_id,
                'stok_tanggal' => now()->addDays($dayOffset),
                'stok_jumlah'  => $jumlah,
            ]);
        }
    }
}
