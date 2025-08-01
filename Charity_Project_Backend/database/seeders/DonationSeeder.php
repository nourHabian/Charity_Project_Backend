<?php

namespace Database\Seeders;

use App\Models\Donation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $donations = [
            [
                'user_id' => 1,
                'recipient_number' => '0966871652',
                'recipient_name' => 'heba',
                'amount' => 10000,
                'type' => 'هدية',
                'delivered' => false,
            ],

            [
                'user_id' => 2,
                'recipient_number' => '0966871653',
                'recipient_name' => 'hala',
                'amount' => 50000,
                'type' => 'هدية',
                'delivered' => true,
            ],

            [
                'user_id' => 6,
                'recipient_number' => '0966871655',
                'recipient_name' => 'dana',
                'amount' => 50000,
                'type' => 'هدية',
                'delivered' => true,
            ],

            [ 
                'user_id' => 7,
                'recipient_number' => '0987654321',
                'recipient_name' => 'ali',
                'amount' => 250000,
                'type' => 'هدية',
                'delivered' => true,
            ],

            [
                'user_id' => 9 ,
                'recipient_number' => '0912345678',
                'recipient_name' => 'omar',
                'amount' => 100000,
                'type' => 'هدية',
                'delivered' => false,
            ],

            [
                'user_id' => 6,
                'recipient_number' => '0966871655',
                'recipient_name' => 'dana',
                'amount' => 800000,
                'type' => 'هدية',
                'delivered' => false,
            ]
            ];

            foreach ($donations as $donation) {
            Donation::create([
                'user_id' => $donation['user_id'],
                'recipient_number' => $donation['recipient_number'],
                'recipient_name' => $donation['recipient_name'],
                'amount' => $donation['amount'],
                'type' => $donation['type'],
                'delivered' => $donation['delivered'],

            ]);
    }
}
    }

