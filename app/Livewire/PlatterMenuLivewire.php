<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PlatterMenu;

class PlatterMenuLivewire extends Component
{
    public function render()
    {
        $items = PlatterMenu::orderBy('name')->get();

        return view('livewire.platter-menu', [
            'items' => $items
        ]);
    }
} 