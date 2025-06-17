<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPinjaman extends Model
{
    public $table = 'pengajuan_pinjaman';

    protected $fillable = [
        'id_anggota',
        'jumlah_pinjaman',
        'bunga_pinjaman_per_bulan',
        'angsuran_per_bulan',
        'status_persetujuan_admin',
        'status_persetujuan_ketua',
        'total_pinjaman'
    ];
}
