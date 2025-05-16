<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroMealSeeder extends Seeder
{
    public function run()
    {
        $meals = [
            [
                'name' => 'Porterhouse Steak',
                'description' => 'Premium cut steak served with rice and vegetables',
                'price' => 205.00,
                'image_path' => 'images/hero-meals/porterhouse.png'
            ],
            [
                'name' => 'Flavored Wings',
                'description' => 'Crispy chicken wings with your choice of flavor',
                'price' => 135.00,
                'image_path' => 'images/hero-meals/flavored-wings.png'
            ],
            [
                'name' => 'Salisbury Steak',
                'description' => 'Classic ground beef patty with mushroom gravy',
                'price' => 140.00,
                'image_path' => 'images/hero-meals/salisbury.png'
            ],
            [
                'name' => 'Famous Ribs',
                'description' => 'Tender pork ribs with special barbecue sauce',
                'price' => 125.00,
                'image_path' => 'images/hero-meals/famous-ribs.png'
            ],
            [
                'name' => 'Lechon Kawali',
                'description' => 'Crispy fried pork belly served with rice',
                'price' => 140.00,
                'image_path' => 'images/hero-meals/lechon-kawali.png'
            ],
            [
                'name' => 'Chicken Thigh BBQ',
                'description' => 'Grilled chicken thigh with barbecue sauce',
                'price' => 150.00,
                'image_path' => 'images/hero-meals/chicken-bbq.png'
            ],
        ];

        foreach ($meals as $meal) {
            DB::table('hero_meals')->insert($meal);
        }
    }
} 