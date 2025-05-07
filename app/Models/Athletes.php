<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athletes extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'country',
        'sports_id',
    ];
    protected $table = 'athletes';

    public function sport()
    {
        return $this->belongsTo(Sports::class, 'sports_id');
    }
}
