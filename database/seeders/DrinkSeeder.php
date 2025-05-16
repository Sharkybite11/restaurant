<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrinkSeeder extends Seeder
{
    public function run()
    {
        $drinks = [
            [
                'name' => 'Lemon Iced Tea',
                'description' => 'Refreshing iced tea with lemon',
                'price' => 40.00,
                'image_path' => 'images/drinks/lemon-iced-tea.png'
            ],
            [
                'name' => 'Coke Regular',
                'description' => 'Classic Coca-Cola soft drink',
                'price' => 25.00,
                'image_path' => 'images/drinks/coke-regular.png'
            ],
            [
                'name' => 'Passion Fruit Juice',
                'description' => 'Fresh passion fruit juice',
                'price' => 95.00,
                'image_path' => 'images/drinks/passion-fruit-juice.png'
            ],
            [
                'name' => 'Brewed Coffee',
                'description' => 'Freshly brewed coffee',
                'price' => 55.00,
                'image_path' => 'images/drinks/brewed-coffee.png'
            ],
            [
                'name' => 'Cucumber Lemonade',
                'description' => 'Refreshing cucumber and lemon drink',
                'price' => 40.00,
                'image_path' => 'images/drinks/cucumber-lemonade.png'
            ],
        ];

        foreach ($drinks as $drink) {
            DB::table('drinks')->insert($drink);
        }
    }
} 