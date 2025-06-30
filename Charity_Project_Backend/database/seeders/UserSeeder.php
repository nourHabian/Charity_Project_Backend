<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'full_name' => 'tuka',
            'email' => 'tukaaalesh8@gmail.com',
            'phone_number' => '0999999999',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
            'points'=>99,
      ]);

        User::create([
            'full_name' => 'noor',
            'email' => 'noor@gmail.com',
            'phone_number' => '099999990',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
              'points'=>88
        ]);

         User::create([
            'full_name' => 'lana',
            'email' => 'lana@gmail.com',
            'phone_number' => '09999998',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
             'role' => 'متبرع',
          'points'=>80
        ]);

         
         
        
 
        

         User::create([
            'full_name' => 'hala',
            'email' => 'hala@gmail.com',
            'phone_number' => '0937485780',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',

        ]);


        User::create([
            'full_name' => 'heba',
            'email' => 'heba@gmail.com',
            'phone_number' => '0937485781',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
        ]);
    }
}
