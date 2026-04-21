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
            $table->integer('stok_id')->autoIncrement();
            $table->integer('supplier_id')->unsigned();
            $table->integer('barang_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->dateTime('stok_tanggal');
            $table->integer('stok_jumlah');

            $table->foreign('supplier_id')
                  ->references('supplier_id')
                  ->on('m_supplier')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('barang_id')
                  ->references('barang_id')
                  ->on('m_barang')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('m_user')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_stok');
    }
};
