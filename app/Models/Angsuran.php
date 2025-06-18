<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    public $table = 'angsuran';

    protected $fillable = [
        'id_pinjaman',
        'jumlah',
        'pembayaran_ke',
        'status',
    ];
}
