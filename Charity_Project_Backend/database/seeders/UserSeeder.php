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
            'full_name' => 'heba',
            'email' => 'heba@gmail.com',
            'phone_number' => '1234567893',
            'password' => Hash::make(12345678),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'مستفيد',
        ]);
    }
}