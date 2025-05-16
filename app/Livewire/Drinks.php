<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Drink;

class Drinks extends Component
{
    public function render()
    {
        $items = Drink::orderBy('name')->get();

        return view('livewire.drinks', [
            'items' => $items
        ]);
    }
} 