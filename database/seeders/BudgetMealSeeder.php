<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BudgetMealSeeder extends Seeder
{
    public function run()
    {
        $meals = [
            [
                'name' => 'Hotsilog',
                'description' => 'Hotdog, Sinangag, and Itlog',
                'price' => 99.00,
                'image_path' => 'images/budget-meals/hotsilog.png'
            ],
            [
                'name' => 'Shanghaisilog',
                'description' => 'Shanghai, Sinangag, and Itlog',
                'price' => 110.00,
                'image_path' => 'images/budget-meals/shanghaisilog.png'
            ],
            [
                'name' => 'Liemposilog',
                'description' => 'Liempo, Sinangag, and Itlog',
                'price' => 125.00,
                'image_path' => 'images/budget-meals/liemposilog.png'
            ],
            [
                'name' => 'Chicksilog',
                'description' => 'Chicken, Sinangag, and Itlog',
                'price' => 125.00,
                'image_path' => 'images/budget-meals/chicksilog.png'
            ],
            [
                'name' => 'Tocilog',
                'description' => 'Tocino, Sinangag, and Itlog',
                'price' => 115.00,
                'image_path' => 'images/budget-meals/tocilog.png'
            ],
        ];

        foreach ($meals as $meal) {
            DB::table('budget_meals')->insert($meal);
        }
    }
} 