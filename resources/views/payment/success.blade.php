<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center">
                        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <h2 class="mt-4 text-2xl font-bold text-gray-900">Payment Successful!</h2>
                        <p class="mt-2 text-gray-600">Thank you for your order. Your payment has been processed successfully.</p>
                        <div class="mt-6">
                            <p class="text-gray-600">Order ID: {{ $order->id }}</p>
                            <p class="text-gray-600">Total Amount: ₱{{ number_format($order->total, 2) }}</p>
                        </div>
                        <div class="mt-8">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Return to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 