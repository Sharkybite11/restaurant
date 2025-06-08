<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HeroMeal;

class HeroMeals extends Component
{
    public $showItemModal = false;
    public $selectedItem = null;

    public function openItemModal($itemId)
    {
        $this->selectedItem = HeroMeal::find($itemId);
        $this->showItemModal = true;
    }

    public function closeItemModal()
    {
        $this->showItemModal = false;
        $this->selectedItem = null;
    }

    public function render()
    {
        $items = HeroMeal::orderBy('name')->get();

        return view('livewire.hero-meals', [
            'items' => $items
        ]);
    }
} 