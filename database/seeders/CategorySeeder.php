<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['category_name' => 'Hair Care',                 'img_name' => 'hair_care'],
            ['category_name' => 'Skincare',                  'img_name' => 'skincare'],
            ['category_name' => 'Salon Tools & Accessories', 'img_name' => 'salon_tools_improved'],
            ['category_name' => 'Nail & Body Care',          'img_name' => 'nail_body_care'],
        ]);
    }
}