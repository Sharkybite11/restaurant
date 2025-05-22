<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BudgetMeal;

class StaffBudgetMeals extends Component
{
    public $quantities = [];
    public $editingQuantityId = null;

    public function startEditing($itemId)
    {
        $this->editingQuantityId = $itemId;
        $this->quantities[$itemId] = BudgetMeal::find($itemId)?->quantity ?? 0;
    }

    public function stopEditing()
    {
        $this->editingQuantityId = null;
    }

    public function updateQuantity($itemId)
    {
        $quantity = $this->quantities[$itemId] ?? 0;
        $item = BudgetMeal::find($itemId);
        
        if ($item) {
            $item->quantity = $quantity;
            $item->save();
            $this->dispatch('quantity-updated');
        }
        $this->stopEditing();
    }

    public function render()
    {
        return view('livewire.staff-budget-meals', [
            'items' => BudgetMeal::all()
        ]);
    }
} 