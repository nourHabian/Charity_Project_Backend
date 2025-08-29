<?php

namespace Database\Seeders;

use App\Models\Charity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $charity = [
            'number_of_donations' => 0,
            'number_of_beneficiaries' => 0,
            'health_projects_balance' => 1000000,
            'educational_projects_balance' => 1000000,
            'nutritional_projects_balance' => 1000000,
            'housing_projects_balance' => 1000000,
            'religious_projects_balance' => 1000000,
        ];
        Charity::create($charity);
    }
}
