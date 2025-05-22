<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Cart extends Component
{
    public $cartItems = [];
    public $total = 0;
    public $showCheckoutModal = false;
    public $checkoutData = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'address' => '',
        'payment_method' => ''
    ];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = Session::get('cart', []);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function updateQuantity($itemId, $change)
    {
        if (isset($this->cartItems[$itemId])) {
            $newQuantity = $this->cartItems[$itemId]['quantity'] + $change;
            
            if ($newQuantity > 0) {
                $this->cartItems[$itemId]['quantity'] = $newQuantity;
            } else {
                unset($this->cartItems[$itemId]);
            }
            
            Session::put('cart', $this->cartItems);
            $this->calculateTotal();
        }
    }

    public function removeItem($itemId)
    {
        if (isset($this->cartItems[$itemId])) {
            unset($this->cartItems[$itemId]);
            Session::put('cart', $this->cartItems);
            $this->calculateTotal();
        }
    }

    public function clearCart()
    {
        Session::forget('cart');
        $this->cartItems = [];
        $this->total = 0;
    }

    public function toggleCheckoutModal()
    {
        $this->showCheckoutModal = !$this->showCheckoutModal;
    }

    public function processCheckout()
    {
        $this->validate([
            'checkoutData.payment_method' => 'required|in:e-wallet,card,cash'
        ]);

        // Decrease item quantities on order placement
        foreach ($this->cartItems as $itemId => $cartItem) {
            $category = $cartItem['category'] ?? null;
            $quantityOrdered = $cartItem['quantity'] ?? 1;
            $model = null;
            switch ($category) {
                case 'meriendabest':
                    $model = \App\Models\MeriendaBest::find($itemId);
                    break;
                case 'budgetmeals':
                    $model = \App\Models\BudgetMeal::find($itemId);
                    break;
                case 'heromeals':
                    $model = \App\Models\HeroMeal::find($itemId);
                    break;
                case 'combusog':
                    $model = \App\Models\Combusog::find($itemId);
                    break;
                case 'platter':
                    $model = \App\Models\PlatterMenu::find($itemId);
                    break;
                case 'drinks':
                    $model = \App\Models\Drink::find($itemId);
                    break;
            }
            if ($model && $model->quantity >= $quantityOrdered) {
                $model->quantity -= $quantityOrdered;
                $model->save();
            }
        }

        // Store the order and items in the orders table
        \App\Models\Order::create([
            'customer_name' => $this->checkoutData['name'] ?? null,
            'customer_email' => $this->checkoutData['email'] ?? null,
            'customer_phone' => $this->checkoutData['phone'] ?? null,
            'customer_address' => $this->checkoutData['address'] ?? null,
            'payment_method' => $this->checkoutData['payment_method'],
            'total' => $this->total,
            'status' => 'pending',
            'items' => json_encode(array_values($this->cartItems)),
        ]);

        if ($this->checkoutData['payment_method'] === 'e-wallet') {
            $this->clearCart();
            $this->showCheckoutModal = false;
            session()->flash('message', 'Redirecting to Xendit payment...');
        } elseif ($this->checkoutData['payment_method'] === 'card') {
            $this->clearCart();
            $this->showCheckoutModal = false;
            session()->flash('message', 'Processing card payment...');
        } else {
            $this->clearCart();
            $this->showCheckoutModal = false;
            session()->flash('message', 'Order placed successfully! Please prepare exact amount for cash payment.');
        }
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
