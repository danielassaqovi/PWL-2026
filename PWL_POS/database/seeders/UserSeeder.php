<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id ' => 1,
                'id' => 1,
                'username' => 'admin',
                'nama' => 'Administrator',
                'password' => Hash::make('1235'),
            ],
            [
                'user_id ' => 2,
                'id' => 2,
                'username' => 'manager',
                'nama' => 'Manager',
                'password' => Hash::make('1235'),
            ],
            [
                'user_id ' => 3,
                'id' => 3,
                'username' => 'staff',
                'nama' => 'Staff/Kasir',
                'password' => Hash::make('1235'),
            ],
        ];
        DB::table('m_level')->insertOrIgnore($data);
            
    }
}
