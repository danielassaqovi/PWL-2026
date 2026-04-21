<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Level
        DB::table('m_level')->insert([
            ['level_id' => 1, 'level_kode' => 'ADM', 'level_nama' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 2, 'level_kode' => 'KSR', 'level_nama' => 'Kasir', 'created_at' => now(), 'updated_at' => now()],
            ['level_id' => 3, 'level_kode' => 'GDG', 'level_nama' => 'Gudang', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. User
        DB::table('m_user')->insert([
            [
                'user_id' => 1,
                'level_id' => 1,
                'username' => 'admin',
                'nama' => 'Administrator',
                'password' => Hash::make('login'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 2,
                'level_id' => 2,
                'username' => 'kasir',
                'nama' => 'Kasir 1',
                'password' => Hash::make('12345'),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // 3. Kategori
        DB::table('m_kategori')->insert([
            ['kategori_id' => 1, 'kategori_kode' => 'MNM', 'kategori_nama' => 'Minuman', 'created_at' => now(), 'updated_at' => now()],
            ['kategori_id' => 2, 'kategori_kode' => 'MKN', 'kategori_nama' => 'Makanan', 'created_at' => now(), 'updated_at' => now()],
            ['kategori_id' => 3, 'kategori_kode' => 'SNK', 'kategori_nama' => 'Snack', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 4. Supplier
        DB::table('m_supplier')->insert([
            ['supplier_id' => 1, 'supplier_kode' => 'SUP1', 'supplier_nama' => 'Supplier A', 'supplier_alamat' => 'Jl. Merdeka No 1', 'created_at' => now(), 'updated_at' => now()],
            ['supplier_id' => 2, 'supplier_kode' => 'SUP2', 'supplier_nama' => 'Supplier B', 'supplier_alamat' => 'Jl. Keadilan No 2', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 5. Barang
        DB::table('m_barang')->insert([
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'B001', 'barang_nama' => 'Teh Botol', 'harga_beli' => 3000, 'harga_jual' => 4500, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'B002', 'barang_nama' => 'Air Mineral', 'harga_beli' => 2500, 'harga_jual' => 4000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'B003', 'barang_nama' => 'Nasi Goreng Instan', 'harga_beli' => 12000, 'harga_jual' => 15000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 4, 'kategori_id' => 3, 'barang_kode' => 'B004', 'barang_nama' => 'Keripik Kentang', 'harga_beli' => 8000, 'harga_jual' => 10000, 'created_at' => now(), 'updated_at' => now()],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'B005', 'barang_nama' => 'Wafer Coklat', 'harga_beli' => 5000, 'harga_jual' => 7000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 6. Stok
        DB::table('t_stok')->insert([
            ['stok_id' => 1, 'supplier_id' => 1, 'barang_id' => 1, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['stok_id' => 2, 'supplier_id' => 1, 'barang_id' => 2, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 150, 'created_at' => now(), 'updated_at' => now()],
            ['stok_id' => 3, 'supplier_id' => 2, 'barang_id' => 3, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['stok_id' => 4, 'supplier_id' => 2, 'barang_id' => 4, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 200, 'created_at' => now(), 'updated_at' => now()],
            ['stok_id' => 5, 'supplier_id' => 2, 'barang_id' => 5, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 80, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 7. Penjualan
        $today = Carbon::now();
        DB::table('t_penjualan')->insert([
            ['penjualan_id' => 1, 'user_id' => 2, 'pembeli' => 'Budi', 'penjualan_kode' => 'TRX-' . $today->format('Ymd') . '-0001', 'penjualan_tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['penjualan_id' => 2, 'user_id' => 2, 'pembeli' => 'Siti', 'penjualan_kode' => 'TRX-' . $today->format('Ymd') . '-0002', 'penjualan_tanggal' => now(), 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 8. Penjualan Detail
        DB::table('t_penjualan_detail')->insert([
            ['detail_id' => 1, 'penjualan_id' => 1, 'barang_id' => 1, 'harga' => 4500, 'jumlah' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['detail_id' => 2, 'penjualan_id' => 1, 'barang_id' => 2, 'harga' => 4000, 'jumlah' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['detail_id' => 3, 'penjualan_id' => 2, 'barang_id' => 3, 'harga' => 15000, 'jumlah' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['detail_id' => 4, 'penjualan_id' => 2, 'barang_id' => 4, 'harga' => 10000, 'jumlah' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
