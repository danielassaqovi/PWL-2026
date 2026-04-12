<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
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
            ['id' => 1, 'level_kode' => 'ADM', 'level_nama' => 'Administrator'],
            ['id' => 2, 'level_kode' => 'MNG', 'level_nama' => 'Manager'],
            ['id' => 3, 'level_kode' => 'STF', 'level_nama' => 'Staff/kasir'],
            
        ];
        DB::table('m_level')->insertOrIgnore($data);
    }
}
