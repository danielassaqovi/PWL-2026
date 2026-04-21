<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->foreignId('kategori_id')->constrained('m_kategori', 'kategori_id');
            $table->string('barang_kode', 10)->unique();
            $table->string('barang_nama', 100);
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_barang');
    }
};
