<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class StaffOrders extends Component
{
    public function removeOrder($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->delete();
            session()->flash('message', 'Order removed successfully.');
        }
    }

    public function render()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('livewire.staff-orders', [
            'orders' => $orders
        ]);
    }
} 