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
        'houses_id',
    ];
    protected $table = 'bikes';
    public function houses()
    {
        return $this->belongsTo(Houses::class, 'houses_id');
    }
}
