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
            'health_projects_balance' => 0,
            'educational_projects_balance' => 0,
            'nutritional_projects_balance' => 0,
            'housing_projects_balance' => 0
        ];
        Charity::create($charity);
    }
}
