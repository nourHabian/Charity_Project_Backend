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
            'full_name' => 'nour',
            'email' => 'nourhabian04@gmail.com',
            'phone_number' => '0999999999',
            'password' => Hash::make(123456),
            'verification_code' => '1111',
            'verified' => true,
            'role' => 'متبرع',
        ]);
    }
}
