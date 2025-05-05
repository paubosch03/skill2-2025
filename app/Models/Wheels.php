<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wheels extends Model
{
    protected $fillable = [
        'brand',
        'price',
        'stock',
    ];
    protected $table = 'wheels';

}
