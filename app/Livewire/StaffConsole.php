<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MeriendaBest;
use App\Models\BudgetMeal;
use App\Models\HeroMeal;
use App\Models\Combusog;
use App\Models\PlatterMenu;
use App\Models\Drink;

class StaffConsole extends Component
{
    public $search = '';
    public $selectedCategory = 'meriendabest';
    public $quantities = [];

    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
    }

    public function updateQuantity($itemId, $category)
    {
        $quantity = $this->quantities[$itemId] ?? 0;
        
        switch ($category) {
            case 'meriendabest':
                $item = MeriendaBest::find($itemId);
                break;
            case 'budgetmeals':
                $item = BudgetMeal::find($itemId);
                break;
            case 'heromeals':
                $item = HeroMeal::find($itemId);
                break;
            case 'combusog':
                $item = Combusog::find($itemId);
                break;
            case 'platter':
                $item = PlatterMenu::find($itemId);
                break;
            case 'drinks':
                $item = Drink::find($itemId);
                break;
        }

        if ($item) {
            $item->quantity = $quantity;
            $item->save();
            $this->dispatch('quantity-updated');
        }
    }

    public function getSearchResultsProperty()
    {
        if (empty($this->search)) {
            return collect();
        }

        $searchTerm = '%' . $this->search . '%';

        $results = collect();

        // Search in each model
        $results = $results->concat(
            MeriendaBest::where('name', 'like', $searchTerm)
                ->get()
                ->map(function ($item) {
                    $item->category = 'Merienda Best';
                    return $item;
                })
        );

        $results = $results->concat(
            BudgetMeal::where('name', 'like', $searchTerm)
                ->get()
                ->map(function ($item) {
                    $item->category = 'Budget Meals';
                    return $item;
                })
        );

        $results = $results->concat(
            HeroMeal::where('name', 'like', $searchTerm)
                ->get()
                ->map(function ($item) {
                    $item->category = 'Hero Meals';
                    return $item;
                })
        );

        $results = $results->concat(
            Combusog::where('name', 'like', $searchTerm)
                ->get()
                ->map(function ($item) {
                    $item->category = 'Combusog';
                    return $item;
                })
        );

        $results = $results->concat(
            PlatterMenu::where('name', 'like', $searchTerm)
                ->get()
                ->map(function ($item) {
                    $item->category = 'Platter';
                    return $item;
                })
        );

        $results = $results->concat(
            Drink::where('name', 'like', $searchTerm)
                ->get()
                ->map(function ($item) {
                    $item->category = 'Drinks';
                    return $item;
                })
        );

        return $results;
    }

    public function render()
    {
        return view('livewire.staff-console');
    }
} 