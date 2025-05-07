<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Athletes;


class AthletesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Athletes::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'birth_date' => '1990-01-01',
            'country' => 'USA',
        ]);
    }
}
