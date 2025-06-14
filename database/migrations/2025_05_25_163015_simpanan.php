<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('simpanan', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->integer('id_anggota');
            $table->float('simpanan_wajib');
            $table->float('simpanan_pokok');
            $table->float('simpanan_sukarela');
            $table->float('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanan');
    }
};
