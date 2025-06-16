<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
        public $table = 'pinjaman';

    protected $fillable = [
        'id_anggota',
        'jumlah_pinjaman',
        'bunga_pinjaman_per_bulan',
        'status',
        'angsuran_per_bulan',
        'total_pinjaman',
    ];
}
