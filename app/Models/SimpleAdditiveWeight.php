<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SimpleAdditiveWeight extends Model
{
    public $table = 'simple_additive_weight';

    protected $fillable = [
        'value',
    ];
}
