<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlatterMenuSeeder extends Seeder
{
    public function run()
    {
        $meals = [
            [
                'name' => 'Plain Rice',
                'description' => 'Steamed white rice',
                'price' => 100.00,
                'image_path' => 'images/platter-menu/plain-rice.png'
            ],
            [
                'name' => 'Java Rice',
                'description' => 'Special fried rice with Java sauce',
                'price' => 110.00,
                'image_path' => 'images/platter-menu/java-rice.png'
            ],
            [
                'name' => 'Stir Fry Vegies',
                'description' => 'Assorted vegetables stir-fried in special sauce',
                'price' => 185.00,
                'image_path' => 'images/platter-menu/stir-fry-vegies.png'
            ],
            [
                'name' => 'Bulalo',
                'description' => 'Traditional Filipino beef shank soup with vegetables',
                'price' => 309.00,
                'image_path' => 'images/platter-menu/bulalo.png'
            ],
            [
                'name' => 'Sinigang',
                'description' => 'Filipino sour soup with meat and vegetables',
                'price' => 309.00,
                'image_path' => 'images/platter-menu/sinigang.png'
            ],
        ];

        foreach ($meals as $meal) {
            DB::table('platter_menu')->insert($meal);
        }
    }
} 