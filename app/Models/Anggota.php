<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    public $table = 'anggota';

    protected $fillable = [
        'id_user',
        'alamat',
        'nik',
        'nomor_hp',
        'status',
    ];
}
