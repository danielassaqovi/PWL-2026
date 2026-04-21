<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // [kategori_kode, barang_kode, barang_nama, harga_beli, harga_jual]
            ['MKN', 'BRG001', 'Mie Instan Goreng',      2000,  3000],
            ['MKN', 'BRG002', 'Biscuit Cokelat',         5000,  7000],
            ['MKN', 'BRG003', 'Roti Tawar Gandum',       8000, 11000],
            ['MNM', 'BRG004', 'Air Mineral 600ml',       2000,  3500],
            ['MNM', 'BRG005', 'Minuman Teh Botol 350ml', 3000,  5000],
            ['MNM', 'BRG006', 'Jus Jeruk Kemasan',       5000,  8000],
            ['KBR', 'BRG007', 'Sabun Mandi Batang',      3500,  5500],
            ['KBR', 'BRG008', 'Shampoo Sachet',          1500,  2500],
            ['ELK', 'BRG009', 'Baterai AA Isi 2',        8000, 12000],
            ['ELK', 'BRG010', 'Lampu LED 5 Watt',       18000, 25000],
            ['LNY', 'BRG011', 'Pulpen Ballpoint',        2000,  3000],
            ['LNY', 'BRG012', 'Buku Tulis 38 Lembar',   5000,  8000],
        ];
        foreach ($data as [$katKode, $kode, $nama, $beli, $jual]) {
            $kategori = \App\Models\Kategori::where('kategori_kode', $katKode)->first();
            \App\Models\Barang::updateOrCreate(
                ['barang_kode' => $kode],
                [
                    'kategori_id' => $kategori->kategori_id,
                    'barang_kode' => $kode,
                    'barang_nama' => $nama,
                    'harga_beli'  => $beli,
                    'harga_jual'  => $jual,
                ]
            );
        }
    }
}
