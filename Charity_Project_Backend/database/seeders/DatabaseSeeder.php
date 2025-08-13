<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            TypeSeeder::class,
            UserSeeder::class,
            ProjectSeeder::class,
            CharitySeeder::class,
            FeedbackSeeder::class,
            AdminSeeder::class,
            SupplySeeder::class,
            VolunteerRequestsSeeder::class,
            BeneficiaryRequestsSeeder::class,
            DonationSeeder::class,
            VolunteerSeeder::class, // if this seeder stopped working, the project current_amount should be modified from the projectSeeder

        ]);
    }
}
