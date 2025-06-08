<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Services\XenditService;
use Illuminate\Support\Str;

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

    protected $xenditService;

    public function boot(XenditService $xenditService)
    {
        $this->xenditService = $xenditService;
    }

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
            'checkoutData.name' => 'required|string',
            'checkoutData.email' => 'required|email',
            'checkoutData.phone' => 'required|string',
            'checkoutData.address' => 'required|string',
            'checkoutData.payment_method' => 'required|in:e-wallet,card,cash'
        ]);

        // Create order first
        $order = \App\Models\Order::create([
            'customer_name' => $this->checkoutData['name'],
            'customer_email' => $this->checkoutData['email'],
            'customer_phone' => $this->checkoutData['phone'],
            'customer_address' => $this->checkoutData['address'],
            'payment_method' => $this->checkoutData['payment_method'],
            'total' => $this->total,
            'status' => 'pending',
            'items' => json_encode(array_values($this->cartItems)),
        ]);

        if ($this->checkoutData['payment_method'] === 'e-wallet') {
            try {
                // Prepare items for Xendit invoice
                $items = collect($this->cartItems)->map(function ($item) {
                    return [
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity']
                    ];
                })->toArray();

                // Create Xendit invoice
                $invoiceData = [
                    'external_id' => 'ORDER-' . $order->id . '-' . Str::random(6),
                    'amount' => $this->total,
                    'description' => 'Payment for Order #' . $order->id,
                    'customer_name' => $this->checkoutData['name'],
                    'customer_email' => $this->checkoutData['email'],
                    'items' => $items,
                    'success_url' => route('payment.success', ['order_id' => $order->id]),
                    'failure_url' => route('payment.failure', ['order_id' => $order->id]),
                ];

                $invoice = $this->xenditService->createInvoice($invoiceData);

                // Update order with Xendit invoice ID
                $order->update([
                    'xendit_invoice_id' => $invoice['id'],
                    'xendit_invoice_url' => $invoice['invoice_url']
                ]);

                $this->clearCart();
                $this->showCheckoutModal = false;
                
                // Redirect to Xendit payment page
                return redirect()->away($invoice['invoice_url']);
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to process payment: ' . $e->getMessage());
                return;
            }
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
