<div class="orders-list">
    <style>
        .orders-list {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .order-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 24px;
            padding: 18px 24px;
            position: relative;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .remove-order-btn {
            background: #ff4444;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 6px 16px;
            cursor: pointer;
            font-size: 0.95rem;
            transition: background 0.2s;
        }
        .remove-order-btn:hover {
            background: #c00;
        }
        .order-items ul {
            margin: 0;
            padding-left: 18px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-radius: 6px;
            padding: 10px 16px;
            margin-bottom: 18px;
            font-weight: 500;
        }
        </style> 
    @if(session()->has('message'))
        <div class="alert-success">{{ session('message') }}</div>
    @endif
    <h2>All Orders</h2>
    @forelse($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <div><strong>Order #{{ $order->id }}</strong> | <span>{{ $order->created_at->format('Y-m-d H:i') }}</span></div>
                <button class="remove-order-btn" wire:click="removeOrder({{ $order->id }})">Remove</button>
            </div>
            <div><strong>Payment:</strong> {{ ucfirst($order->payment_method) }}</div>
            <div><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
            <div><strong>Total:</strong> ₱{{ number_format($order->total, 2) }}</div>
            <div class="order-items">
                <strong>Items:</strong>
                <ul>
                    @php
                        $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
                    @endphp
                    @foreach($items as $item)
                        <li>
                            {{ $item['name'] }} (x{{ $item['quantity'] }}) - ₱{{ number_format($item['price'], 2) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <div>No orders found.</div>
    @endforelse
</div>

