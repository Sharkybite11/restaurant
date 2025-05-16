<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CombusogSeeder extends Seeder
{
    public function run()
    {
        $meals = [
            [
                'name' => 'Pork Adobo with Ensaladang Talong and Rice',
                'description' => 'Classic Filipino pork adobo served with grilled eggplant salad and rice',
                'price' => 149.00,
                'image_path' => 'images/combusog/pork-adobo-combo.png'
            ],
            [
                'name' => 'Crispy Fried Chicken with Stir Fry Vegies and Lumpiang Shanghai',
                'description' => 'Crispy fried chicken served with stir-fried vegetables and spring rolls with Java rice',
                'price' => 159.00,
                'image_path' => 'images/combusog/chicken-combo.png'
            ],
            [
                'name' => "Bochog's Original Sisig with Lumpiang Shanghai",
                'description' => 'Signature sisig served with spring rolls and Java rice',
                'price' => 159.00,
                'image_path' => 'images/combusog/sisig-combo.png'
            ],
        ];

        foreach ($meals as $meal) {
            DB::table('combusog')->insert($meal);
        }
    }
} 