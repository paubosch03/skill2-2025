<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bikes extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'type',
        'color',
        'frame_material',
        'speeds',
        'price',
    ];
    protected $table = 'bikes';
}
