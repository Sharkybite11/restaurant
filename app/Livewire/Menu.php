<?php

namespace App\Livewire;

use Livewire\Component;

class Menu extends Component
{
    public $type = 'dine-in';
    public $selectedCategory = 'all';

    public function mount($type = null)
    {
        if ($type && in_array($type, ['dine-in', 'to-go'])) {
            $this->type = $type;
        }
    }

    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
    }

    public function render()
    {
        return view('livewire.menu', [
            'type' => $this->type
        ]);
    }
}
