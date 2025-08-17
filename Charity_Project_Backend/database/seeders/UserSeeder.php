<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
            'points' => 99,
        ]);

        User::create([
            'full_name' => 'noor',
            'email' => 'noor@gmail.com',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
            'points' => 88
        ]);

        User::create([
            'full_name' => 'lana',
            'email' => 'lana@gmail.com',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
            'points' => 80
        ]);




        User::create([
            'full_name' => 'hala',
            'email' => 'hala@gmail.com',
            'phone_number' => '0966871653',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',

        ]);

        
        User::create([
            'full_name' => 'halaa',
            'email' => 'halaa@gmail.com',
            'phone_number' => '0966879653',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',

        ]);
          
        
        User::create([
            'full_name' => 'hala',
            'email' => 'hala22@gmail.com',
            'phone_number' => '0966876653',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',

        ]);

        User::create([
            'full_name' => 'heba',
            'email' => 'heba@gmail.com',
            'phone_number' => '0966871652',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
        ]);

        User::create([
            'full_name' => 'hebaa',
            'email' => 'hebaa@gmail.com',
            'phone_number' => '0966851652',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
        ]);


        User::create([
            'full_name' => 'test1',
            'email' => 'test1@gmail.com',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
            'points' => 0,
        ]);
        User::create([
            'full_name' => 'test2',
            'email' => 'test2@gmail.com',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
            'points' => 0,
        ]);
        User::create([
            'full_name' => 'test3',
            'email' => 'test3@gmail.com',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
            'points' => 0,
        ]);
        User::create([
            'full_name' => 'test4',
            'email' => 'test4@gmail.com',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
            'points' => 0,
        ]);
        User::create([
            'full_name' => 'test5',
            'email' => 'test5@gmail.com',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
            'points' => 0,
        ]);
        User::create([
            'full_name' => 'test6',
            'email' => 'test6@gmail.com',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
            'points' => 0,
        ]);
          User::create([
            'full_name' => 'ali',
            'email' => 'ali@gmail.com',
            'phone_number' => '0987654321',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
            'created_at' => Carbon::create(2023, 1, 15, 10, 0, 0),
        ]);
          User::create([
            'full_name' => 'omar',
            'email' => 'omar@gmail.com',
            'phone_number' => '0912345678',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
            'created_at' => Carbon::create(2023, 1, 15, 10, 0, 0),

        ]);
          User::create([
            'full_name' => 'dana',
            'email' => 'dana@gmail.com',
            'phone_number' => '0966871655',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
            'created_at' => Carbon::create(2023, 1, 15, 10, 0, 0),

        ]);

          User::create([
            'full_name' => 'lolo',
            'email' => 'lolo@gmail.com',
            'phone_number' => '0956871655',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
            'created_at' => Carbon::create(2024, 1, 15, 10, 0, 0),

        ]);

        
          User::create([
            'full_name' => 'lolooo',
            'email' => 'lolo1@gmail.com',
            'phone_number' => '0958871655',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
            'created_at' => Carbon::create(2022, 1, 15, 10, 0, 0),

        ]);
        
          User::create([
            'full_name' => 'haneen',
            'email' => 'haneen1@gmail.com',
            'phone_number' => '0958271655',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
            'created_at' => Carbon::create(2021, 1, 15, 10, 0, 0),

        ]);
        User::create([
            'full_name' => 'luna',
            'email' => 'luna1@gmail.com',
            'phone_number' => '0958071655',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
            'created_at' => Carbon::create(2021, 1, 15, 10, 0, 0),

        ]);


    }
}