<?php

namespace App\Livewire;

use Livewire\Component;

class CashPayments extends Component
{
    public $cashPayments = [];

    protected $listeners = ['echo:cash-payments,payment.received' => 'handleNewPayment'];

    public function mount()
    {
        // Load any existing cash payments from the database
        $this->loadCashPayments();
    }

    public function loadCashPayments()
    {
        $this->cashPayments = \App\Models\Order::where('payment_method', 'cash')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function handleNewPayment($event)
    {
        $this->cashPayments = array_merge([$event['orderData']], $this->cashPayments);
    }

    public function markAsCompleted($orderId)
    {
        $order = \App\Models\Order::find($orderId);
        if ($order) {
            $order->status = 'completed';
            $order->save();
            
            // Remove from the list
            $this->cashPayments = array_filter($this->cashPayments, function($payment) use ($orderId) {
                return $payment['id'] != $orderId;
            });
        }
    }

    public function render()
    {
        return view('livewire.cash-payments');
    }
} 