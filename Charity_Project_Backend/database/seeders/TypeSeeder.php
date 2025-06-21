<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'صحي'],
            ['name' => 'تعليمي'],
            ['name' => 'سكني'],
            ['name' => 'غذائي'],
            ['name' => 'ميداني'],
            ['name' => 'عن بعد'],
            ['name' => 'عام'],
        ];

        foreach($types as $type) {
            Type::create(['name' => $type['name']]);
        }
    }
}
