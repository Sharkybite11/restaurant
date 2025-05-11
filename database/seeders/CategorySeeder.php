<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Budget Meals',
                'slug' => 'budget-meals',
                'description' => 'Affordable and delicious meals for everyone',
                'display_order' => 1,
            ],
            [
                'name' => 'MeriendaBest',
                'slug' => 'merienda-best',
                'description' => 'Perfect snacks and light meals for merienda time',
                'display_order' => 2,
            ],
            [
                'name' => 'HeroMeals',
                'slug' => 'hero-meals',
                'description' => 'Signature dishes that make you feel like a hero',
                'display_order' => 3,
            ],
            [
                'name' => 'Combusog',
                'slug' => 'combusog',
                'description' => 'Hearty and filling combination meals',
                'display_order' => 4,
            ],
            [
                'name' => 'PlatterMenu',
                'slug' => 'platter-menu',
                'description' => 'Perfect for sharing with family and friends',
                'display_order' => 5,
            ],
            [
                'name' => 'Drinks',
                'slug' => 'drinks',
                'description' => 'Refreshing beverages to complement your meal',
                'display_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'display_order' => $category['display_order'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 