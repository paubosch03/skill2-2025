<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cars extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'make',
        'model',
        'year',
        'color',
        'price',
        'mileage',
        'mileage',
        'fuel_type',
        'transmission',
        'vin',
        'registration_date',
        'is_used',
        'houses_id'
    ];
}
