<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HeroMeal;

class HeroMeals extends Component
{
    public function render()
    {
        $items = HeroMeal::orderBy('name')->get();

        return view('livewire.hero-meals', [
            'items' => $items
        ]);
    }
} 