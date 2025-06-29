<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BudgetMeal;

class BudgetMeals extends Component
{
    public $showItemModal = false;
    public $selectedItem = null;

    public function openItemModal($itemId)
    {
        $this->selectedItem = BudgetMeal::find($itemId);
        $this->showItemModal = true;
    }

    public function closeItemModal()
    {
        $this->showItemModal = false;
        $this->selectedItem = null;
    }

    public function render()
    {
        $items = BudgetMeal::orderBy('name')->get();

        return view('livewire.budget-meals', [
            'items' => $items
        ]);
    }
} 