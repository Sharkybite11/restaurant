<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MeriendaBest;

class StaffMeriendaBest extends Component
{
    public $quantities = [];
    public $editingQuantityId = null;

    public function startEditing($itemId)
    {
        $this->editingQuantityId = $itemId;
        $this->quantities[$itemId] = MeriendaBest::find($itemId)?->quantity ?? 0;
    }

    public function stopEditing()
    {
        $this->editingQuantityId = null;
    }

    public function updateQuantity($itemId)
    {
        $quantity = $this->quantities[$itemId] ?? 0;
        $item = MeriendaBest::find($itemId);
        
        if ($item) {
            $item->quantity = $quantity;
            $item->save();
            $this->dispatch('quantity-updated');
        }
        $this->stopEditing();
    }

    public function render()
    {
        return view('livewire.staff-merienda-best', [
            'items' => MeriendaBest::all()
        ]);
    }
} 