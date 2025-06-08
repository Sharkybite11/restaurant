<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MeriendaBest as MeriendaBestModel;

class MeriendaBest extends Component
{
    public $showItemModal = false;
    public $selectedItem = null;

    public function openItemModal($itemId)
    {
        $this->selectedItem = MeriendaBestModel::find($itemId);
        $this->showItemModal = true;
    }

    public function closeItemModal()
    {
        $this->showItemModal = false;
        $this->selectedItem = null;
    }

    public function render()
    {
        $items = MeriendaBestModel::where('is_available', true)
            ->orderBy('name')
            ->get();

        return view('livewire.merienda-best', [
            'items' => $items
        ]);
    }
}
