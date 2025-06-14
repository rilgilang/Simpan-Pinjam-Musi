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
           Schema::create('histori_simpanan', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->integer('id_simpanan');
            $table->enum('jenis_simpanan', ['wajib', 'sukarela']);
            $table->float('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_simpanan');
    }
};
