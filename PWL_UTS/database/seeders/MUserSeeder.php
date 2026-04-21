<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['level_kode' => 'ADM', 'username' => 'admin',   'nama' => 'Administrator',  'pass' => 'admin123'],
            ['level_kode' => 'MNG', 'username' => 'manager', 'nama' => 'Siti Rahayu',    'pass' => 'manager123'],
            ['level_kode' => 'KSR', 'username' => 'kasir1',  'nama' => 'Budi Santoso',   'pass' => 'kasir123'],
            ['level_kode' => 'KSR', 'username' => 'kasir2',  'nama' => 'Dewi Lestari',   'pass' => 'kasir123'],
        ];
        foreach ($data as $item) {
            $level = \App\Models\Level::where('level_kode', $item['level_kode'])->first();
            \App\Models\MUser::updateOrCreate(
                ['username' => $item['username']],
                [
                    'level_id' => $level->level_id,
                    'username' => $item['username'],
                    'nama'     => $item['nama'],
                    'password' => bcrypt($item['pass']),
                ]
            );
        }
    }
}
