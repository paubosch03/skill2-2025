<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sports;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sports::create([
            'name' => 'Soccer',
            'players_per_team' => 11,
            'category' => 'Team Sport',
        ]);
    }
}
