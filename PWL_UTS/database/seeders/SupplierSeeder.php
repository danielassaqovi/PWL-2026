<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['SUP001', 'PT Sumber Makmur',    'Jl. Raya Diponegoro No.12, Malang'],
            ['SUP002', 'CV Berkah Jaya',       'Jl. Veteran No.45, Surabaya'],
            ['SUP003', 'UD Toko Sejahtera',    'Jl. Ahmad Yani No.8, Malang'],
            ['SUP004', 'PT Nusantara Niaga',   'Jl. Pahlawan No.22, Batu'],
            ['SUP005', 'CV Mitra Abadi',       'Jl. Kawi No.17, Malang'],
        ];
        foreach ($data as [$kode, $nama, $alamat]) {
            \App\Models\Supplier::updateOrCreate(
                ['supplier_kode' => $kode],
                ['supplier_kode' => $kode, 'supplier_nama' => $nama, 'supplier_alamat' => $alamat]
            );
        }
    }
}
