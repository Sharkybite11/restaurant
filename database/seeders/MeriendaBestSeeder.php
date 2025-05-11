<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MeriendaBest;

class MeriendaBestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Fries',
                'price' => 55.00,
                'image_path' => 'images/menu/meriendabest/fries.png',
                'description' => 'Crispy golden fries served hot and fresh',
                'is_available' => true,
            ],
            [
                'name' => 'Nachos',
                'price' => 125.00,
                'image_path' => 'images/menu/meriendabest/nachos.png',
                'description' => 'Crispy tortilla chips topped with cheese, jalapeños, and salsa',
                'is_available' => true,
            ],
            [
                'name' => 'Taco Puffs',
                'price' => 165.00,
                'image_path' => 'images/menu/meriendabest/taco-puffs.png',
                'description' => 'Flaky pastry filled with seasoned taco meat and cheese',
                'is_available' => true,
            ],
            [
                'name' => 'Crispy Chicken Burger',
                'price' => 110.00,
                'image_path' => 'images/menu/meriendabest/chicken-burger.png',
                'description' => 'Crispy chicken patty served in a soft bun with fresh vegetables',
                'is_available' => true,
            ],
            [
                'name' => 'Baked Potatoes',
                'price' => 175.00,
                'image_path' => 'images/menu/meriendabest/baked-potatoes.png',
                'description' => 'Fluffy baked potatoes topped with butter and your choice of toppings',
                'is_available' => true,
            ],
            [
                'name' => 'Cali Burrito',
                'price' => 145.00,
                'image_path' => 'images/menu/meriendabest/cali-burrito.png',
                'description' => 'Large flour tortilla filled with rice, beans, meat, and fresh vegetables',
                'is_available' => true,
            ],
        ];

        foreach ($items as $item) {
            MeriendaBest::create($item);
        }
    }
}
