<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center">
                        <svg class="mx-auto h-16 w-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <h2 class="mt-4 text-2xl font-bold text-gray-900">Payment Failed</h2>
                        <p class="mt-2 text-gray-600">We're sorry, but your payment could not be processed. Please try again.</p>
                        <div class="mt-6">
                            <p class="text-gray-600">Order ID: {{ $order->id }}</p>
                            <p class="text-gray-600">Total Amount: ₱{{ number_format($order->total, 2) }}</p>
                        </div>
                        <div class="mt-8 space-x-4">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Return to Home
                            </a>
                            <a href="{{ route('cart') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                                Try Again
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 