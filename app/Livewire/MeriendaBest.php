<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MeriendaBest as MeriendaBestModel;

class MeriendaBest extends Component
{
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
