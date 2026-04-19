<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_stok', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('stok_id');
            $table->unsignedInteger('supplier_id');
            $table->unsignedInteger('barang_id');
            $table->unsignedInteger('user_id');
            $table->dateTime('stok_tanggal');
            $table->integer('stok_jumlah');

            $table->foreign('supplier_id')->references('supplier_id')->on('m_supplier');
            $table->foreign('barang_id')->references('barang_id')->on('m_barang');
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_stok');
    }
};
