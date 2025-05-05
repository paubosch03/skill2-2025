<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clothes extends Model
{
    protected $fillable = [
        'type',
        'brand',
        'color',
        'size',
        'price',
        'material',
        'gender',
    ];
    protected $table = 'clothes';
}
