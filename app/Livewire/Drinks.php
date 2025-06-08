<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Drink;

class Drinks extends Component
{
    public $showItemModal = false;
    public $selectedItem = null;

    public function openItemModal($itemId)
    {
        $this->selectedItem = Drink::find($itemId);
        $this->showItemModal = true;
    }

    public function closeItemModal()
    {
        $this->showItemModal = false;
        $this->selectedItem = null;
    }

    public function render()
    {
        $items = Drink::orderBy('name')->get();

        return view('livewire.drinks', [
            'items' => $items
        ]);
    }
} 