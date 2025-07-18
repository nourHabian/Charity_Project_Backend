<?php

namespace Database\Seeders;

use App\Models\Supply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplies = [
            ['name' => 'سلة غذائية'],
            ['name' => 'حليب أطفال'],
            ['name' => 'ثياب مدرسية'],
            ['name' => 'أقساط جامعية'],
            ['name' => 'مستلزمات دراسية'],
        ];

        foreach($supplies as $supply) {
            Supply::create(['name' => $supply['name']]);
        }
    }
}
