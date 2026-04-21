<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('user_id', true, true);
            $table->integer('level_id')->unsigned();
            $table->string('username', 20)->unique();
            $table->string('nama', 100);
            $table->string('password', 255);

            $table->foreign('level_id')
                  ->references('level_id')
                  ->on('m_level')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_user');
    }
};
