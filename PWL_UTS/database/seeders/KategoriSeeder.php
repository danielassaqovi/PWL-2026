<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['MKN', 'Makanan'],
            ['MNM', 'Minuman'],
            ['KBR', 'Kebersihan'],
            ['ELK', 'Elektronik'],
            ['LNY', 'Lainnya'],
        ];
        foreach ($data as [$kode, $nama]) {
            \App\Models\Kategori::updateOrCreate(
                ['kategori_kode' => $kode],
                ['kategori_kode' => $kode, 'kategori_nama' => $nama]
            );
        }
    }
}
