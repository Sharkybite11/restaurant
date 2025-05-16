<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BudgetMeal;

class BudgetMeals extends Component
{
    public function render()
    {
        $items = BudgetMeal::orderBy('name')->get();

        return view('livewire.budget-meals', [
            'items' => $items
        ]);
    }
} 