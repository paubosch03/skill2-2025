<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'location',
        'prize',
        'sport_id'
    ];
    protected $table = 'competitions';

    public function sport(){
        return $this->belongsTo(Sports::class, 'sports_id');

    }
}
