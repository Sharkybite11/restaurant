<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Platter;

class PlatterMenu extends Component
{
    public $showItemModal = false;
    public $selectedItem = null;

    public function openItemModal($itemId)
    {
        $this->selectedItem = Platter::find($itemId);
        $this->showItemModal = true;
    }

    public function closeItemModal()
    {
        $this->showItemModal = false;
        $this->selectedItem = null;
    }

    public function render()
    {
        $items = Platter::orderBy('name')->get();

        return view('livewire.platter-menu', [
            'items' => $items
        ]);
    }
} 