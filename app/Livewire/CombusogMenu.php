<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Combusog;

class CombusogMenu extends Component
{
    public $showItemModal = false;
    public $selectedItem = null;

    public function openItemModal($itemId)
    {
        $this->selectedItem = Combusog::find($itemId);
        $this->showItemModal = true;
    }

    public function closeItemModal()
    {
        $this->showItemModal = false;
        $this->selectedItem = null;
    }

    public function render()
    {
        $items = Combusog::orderBy('name')->get();

        return view('livewire.combusog-menu', [
            'items' => $items
        ]);
    }
} 