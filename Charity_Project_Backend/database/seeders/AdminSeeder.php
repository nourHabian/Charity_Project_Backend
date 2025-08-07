<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Admin::create([
      'full_name' => 'SuperAdmin',
      'email' => 'SuperAdmin@gmail.com',
      'password' => Hash::make(12345678),
      'is_super_admin' => true,
    ]);
    Admin::create([
      'full_name' => 'Admin_01',
      'email' => 'Admin_01@gmail.com',
      'password' => Hash::make(12345678),
    ]);
    Admin::create([
      'full_name' => 'Admin_02',
      'email' => 'Admin_02@gmail.com',
      'password' => Hash::make(12345678),
    ]);
    Admin::create([
      'full_name' => 'Admin_03',
      'email' => 'Admin_03@gmail.com',
      'password' => Hash::make(12345678),
      'deleted' => true,
    ]);
  }
}
