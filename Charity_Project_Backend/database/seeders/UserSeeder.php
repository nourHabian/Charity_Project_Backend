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
    }
}