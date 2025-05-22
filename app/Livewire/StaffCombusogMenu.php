<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Combusog;

class StaffCombusogMenu extends Component
{
    public $quantities = [];
    public $editingQuantityId = null;

    public function startEditing($itemId)
    {
        $this->editingQuantityId = $itemId;
        $this->quantities[$itemId] = Combusog::find($itemId)?->quantity ?? 0;
    }

    public function stopEditing()
    {
        $this->editingQuantityId = null;
    }

    public function updateQuantity($itemId)
    {
        $quantity = $this->quantities[$itemId] ?? 0;
        $item = Combusog::find($itemId);
        
        if ($item) {
            $item->quantity = $quantity;
            $item->save();
            $this->dispatch('quantity-updated');
        }
        $this->stopEditing();
    }

    public function render()
    {
        return view('livewire.staff-combusog-menu', [
            'items' => Combusog::all()
        ]);
    }
} 