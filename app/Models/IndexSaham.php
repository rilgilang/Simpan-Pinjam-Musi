<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexSaham extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    public $table = 'index_saham';

    protected $fillable = [
        'index_saham',
        'tahun',
    ];
}
