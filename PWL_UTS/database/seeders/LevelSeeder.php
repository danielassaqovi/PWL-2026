<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['level_kode' => 'ADM', 'level_nama' => 'Administrator'],
            ['level_kode' => 'MNG', 'level_nama' => 'Manajer'],
            ['level_kode' => 'KSR', 'level_nama' => 'Kasir'],
        ];
        foreach ($data as $item) {
            \App\Models\Level::updateOrCreate(
                ['level_kode' => $item['level_kode']], $item
            );
        }
    }
}
