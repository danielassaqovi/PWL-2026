<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,  // login Filament
            LevelSeeder::class,
            SupplierSeeder::class,
            KategoriSeeder::class,
            MUserSeeder::class,
            BarangSeeder::class,
            StokSeeder::class,
            PenjualanSeeder::class,
        ]);
    }
}
