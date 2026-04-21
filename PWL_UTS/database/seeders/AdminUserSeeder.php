<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@pwluts.com'],
            [
                'name'              => 'Administrator',
                'email'             => 'admin@pwluts.com',
                'email_verified_at' => now(),
                'password'          => \Illuminate\Support\Facades\Hash::make('admin123'),
            ]
        );

        $this->command->info('✅ Admin Filament berhasil dibuat!');
        $this->command->info('   Email    : admin@pwluts.com');
        $this->command->info('   Password : admin123');
    }
}
