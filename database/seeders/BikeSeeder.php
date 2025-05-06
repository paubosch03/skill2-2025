<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bikes;

class BikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bikes::create([
            'brand' => 'Trek',
            'model' => 'Domane SL 7',
            'type' => 'Road',
            'color' => 'Black',
            'frame_material' => 'Carbon',
            'speeds' => 22,
            'price' => 4999.99,
        ]);
    }
}
