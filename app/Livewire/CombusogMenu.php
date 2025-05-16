<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Combusog;

class CombusogMenu extends Component
{
    public function render()
    {
        $items = Combusog::orderBy('name')->get();

        return view('livewire.combusog-menu', [
            'items' => $items
        ]);
    }
} 