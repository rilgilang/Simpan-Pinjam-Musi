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
         Schema::create('pengajuan_pinjaman', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->integer('id_anggota');
            $table->float('jumlah_pinjaman');
            $table->float('bunga_pinjaman_per_bulan');
            $table->float('angsuran_per_bulan');
            $table->enum('status_persetujuan_admin', ['ditolak','menunggu', 'disetujui']);
            $table->enum('status_persetujuan_ketua', ['ditolak','menunggu', 'disetujui']);
            $table->float('total_pinjaman');
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pinjaman');
    }
};
