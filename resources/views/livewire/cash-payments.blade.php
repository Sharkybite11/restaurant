<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Cash Payments</h2>
    
    <div class="space-y-4">
        @forelse($cashPayments as $payment)
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold text-lg">{{ $payment['customer_name'] ?? 'Walk-in Customer' }}</h3>
                        <p class="text-gray-600">Order Total: ₱{{ number_format($payment['total'], 2) }}</p>
                        <p class="text-sm text-gray-500">Ordered at: {{ $payment['created_at'] }}</p>
                        
                        @if($payment['customer_phone'])
                            <p class="text-sm text-gray-500">Phone: {{ $payment['customer_phone'] }}</p>
                        @endif
                        
                        <div class="mt-2">
                            <h4 class="font-medium">Order Items:</h4>
                            <ul class="list-disc list-inside text-sm">
                                @foreach($payment['items'] as $item)
                                    <li>{{ $item['name'] }} x {{ $item['quantity'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                    <button wire:click="markAsCompleted({{ $payment['id'] }})"
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                        Mark as Completed
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-8">
                No pending cash payments
            </div>
        @endforelse
    </div>
</div> 