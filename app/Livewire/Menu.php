<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Menu extends Component
{
    public $type = 'dine-in';
    public $selectedCategory = 'all';
    public $search = '';

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

    public function updatedSearch()
    {
        $this->selectedCategory = 'all';
    }

    public function addToCart($itemId, $category)
    {
        $cart = Session::get('cart', []);
        
        // Get the item based on category
        $item = null;
        switch($category) {
            case 'meriendabest':
                $item = \App\Models\MeriendaBest::find($itemId);
                $categoryName = 'Merienda Best';
                break;
            case 'budgetmeals':
                $item = \App\Models\BudgetMeal::find($itemId);
                $categoryName = 'Budget Meals';
                break;
            case 'heromeals':
                $item = \App\Models\HeroMeal::find($itemId);
                $categoryName = 'Hero Meals';
                break;
            case 'combusog':
                $item = \App\Models\Combusog::find($itemId);
                $categoryName = 'Combusog';
                break;
            case 'platter':
                $item = \App\Models\PlatterMenu::find($itemId);
                $categoryName = 'Platter';
                break;
            case 'drinks':
                $item = \App\Models\Drink::find($itemId);
                $categoryName = 'Drinks';
                break;
        }

        if ($item) {
            $cartItemId = $category . '_' . $itemId;
            
            if (isset($cart[$cartItemId])) {
                $cart[$cartItemId]['quantity']++;
            } else {
                $cart[$cartItemId] = [
                    'id' => $itemId,
                    'name' => $item->name,
                    'price' => $item->price,
                    'image_path' => $item->image_path,
                    'category' => $categoryName,
                    'quantity' => 1
                ];
            }
            
            Session::put('cart', $cart);
            $this->dispatch('cart-updated');
        }
    }

    public function render()
    {
        $searchResults = [];
        
        if (!empty($this->search)) {
            $searchResults = collect();
            
            // Search in MeriendaBest
            $searchResults = $searchResults->concat(
                \App\Models\MeriendaBest::where('name', 'like', '%' . $this->search . '%')
                    ->where('is_available', true)
                    ->get()
                    ->map(function ($item) {
                        $item->category = 'Merienda Best';
                        return $item;
                    })
            );
            
            // Search in BudgetMeals
            $searchResults = $searchResults->concat(
                \App\Models\BudgetMeal::where('name', 'like', '%' . $this->search . '%')
                    ->get()
                    ->map(function ($item) {
                        $item->category = 'Budget Meals';
                        return $item;
                    })
            );
            
            // Search in HeroMeals
            $searchResults = $searchResults->concat(
                \App\Models\HeroMeal::where('name', 'like', '%' . $this->search . '%')
                    ->get()
                    ->map(function ($item) {
                        $item->category = 'Hero Meals';
                        return $item;
                    })
            );
            
            // Search in Combusog
            $searchResults = $searchResults->concat(
                \App\Models\Combusog::where('name', 'like', '%' . $this->search . '%')
                    ->get()
                    ->map(function ($item) {
                        $item->category = 'Combusog';
                        return $item;
                    })
            );
            
            // Search in PlatterMenu
            $searchResults = $searchResults->concat(
                \App\Models\PlatterMenu::where('name', 'like', '%' . $this->search . '%')
                    ->get()
                    ->map(function ($item) {
                        $item->category = 'Platter';
                        return $item;
                    })
            );
            
            // Search in Drinks
            $searchResults = $searchResults->concat(
                \App\Models\Drink::where('name', 'like', '%' . $this->search . '%')
                    ->get()
                    ->map(function ($item) {
                        $item->category = 'Drinks';
                        return $item;
                    })
            );
        }

        return view('livewire.menu', [
            'type' => $this->type,
            'searchResults' => $searchResults
        ]);
    }
}
