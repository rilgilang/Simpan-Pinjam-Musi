<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    public $table = 'simpanan';

    protected $fillable = [
        'id_anggota',
        'simpanan_wajib',
        'simpanan_pokok',
        'simpanan_sukarela',
        'jumlah',
    ];
}
