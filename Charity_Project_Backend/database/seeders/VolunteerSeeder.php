<?php

namespace Database\Seeders;

use App\Models\Volunteer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Volunteer::create([
            'user_id' => 7,
            'project_id' => 3,
        ]);
        Volunteer::create([
            'user_id' => 8,
            'project_id' => 3,
        ]);
        Volunteer::create([
            'user_id' => 11,
            'project_id' => 4,
        ]);
    }
}
