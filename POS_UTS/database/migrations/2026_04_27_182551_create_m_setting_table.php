<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_setting', function (Blueprint $table) {
            $table->id('setting_id');
            $table->string('key')->unique();
            $table->string('value')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        // Seed default tax value (0%)
        DB::table('m_setting')->insert([
            'key' => 'pajak_persentase',
            'value' => '0',
            'keterangan' => 'Persentase pajak penjualan (%)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('m_setting');
    }
};
