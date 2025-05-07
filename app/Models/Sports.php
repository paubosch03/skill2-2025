<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sports extends Model
{
    protected $fillable = [
        'name',
        'category',
        'players_per_team',
    ];

    protected $table = 'sports';
}
