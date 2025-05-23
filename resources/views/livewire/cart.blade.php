<div class="cart-page">
    @if(session()->has('debug'))
        <div style="background: #f0f0f0; padding: 10px; margin: 10px; border-radius: 4px;">
            Debug: {{ session('debug') }}
        </div>
    @endif
    <div class="cart-container">
        <div class="cart-header">
            <h1>Your Cart</h1>
            @if(count($cartItems) > 0)
                <button wire:click="clearCart" class="clear-cart-btn">Clear Cart</button>
            @endif
        </div>

        @if(count($cartItems) > 0)
            <div class="cart-items">
                @foreach($cartItems as $itemId => $item)
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="{{ asset($item['image_path']) }}" alt="{{ $item['name'] }}">
                        </div>
                        <div class="item-details">
                            <h3>{{ $item['name'] }}</h3>
                            <p class="item-category">{{ $item['category'] }}</p>
                            <div class="item-price">₱{{ number_format($item['price'], 2) }}</div>
                        </div>
                        <div class="quantity-controls">
                            <button wire:click="updateQuantity('{{ $itemId }}', -1)" class="quantity-btn">-</button>
                            <span class="quantity">{{ $item['quantity'] }}</span>
                            <button wire:click="updateQuantity('{{ $itemId }}', 1)" class="quantity-btn">+</button>
                        </div>
                        <div class="item-total">
                            ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                        </div>
                        <button wire:click="removeItem('{{ $itemId }}')" class="remove-item-btn">
                            <img src="{{ asset('images/trash.png') }}" alt="Remove" class="trash-icon">
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>₱{{ number_format($total, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>VAT (12%):</span>
                    <span>₱{{ number_format($total * 0.12, 2) }}</span>
                </div>
                <div class="summary-row total">
                    <span>Total:</span>
                    <span>₱{{ number_format($total * 1.12, 2) }}</span>
                </div>
                <button wire:click="toggleCheckoutModal" class="checkout-btn">Proceed to Checkout</button>
            </div>
        @else
            <div class="empty-cart">
                <h2>Your cart is empty</h2>
                <p>Add items to your cart</p>
                <a href="/menu" class="continue-shopping-btn">Continue Shopping</a>
            </div>
        @endif
    </div>
    <!-- Checkout Modal -->
@if($showCheckoutModal)
    <div class="modal-overlay" wire:click="toggleCheckoutModal">
        <div class="modal-content" wire:click.stop>
            <div class="modal-header">
                <h2>Checkout</h2>
                <button wire:click="toggleCheckoutModal" class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>₱{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>VAT (12%):</span>
                            <span>₱{{ number_format($total * 0.12, 2) }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span>₱{{ number_format($total * 1.12, 2) }}</span>
                        </div>
                    </div>
                </div>

                @if(!$checkoutData['payment_method'])
                    <div class="payment-selection">
                        <h4>Select Payment Method</h4>
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" wire:model.live="checkoutData.payment_method" value="e-wallet" required>
                                <span class="payment-label">
                                    <img src="{{ asset('images/e-wallet.png') }}" alt="E-Wallet" class="payment-icon">
                                    E-Wallet (Xendit)
                                </span>
                            </label>
                            <label class="payment-option">
                                <input type="radio" wire:model.live="checkoutData.payment_method" value="card" required>
                                <span class="payment-label">
                                    <img src="{{ asset('images/card.png') }}" alt="Card" class="payment-icon">
                                    Credit/Debit Card
                                </span>
                            </label>
                            <label class="payment-option">
                                <input type="radio" wire:model.live="checkoutData.payment_method" value="cash" required>
                                <span class="payment-label">
                                    <img src="{{ asset('images/cash.png') }}" alt="Cash" class="payment-icon">
                                    Cash
                                </span>
                            </label>
                        </div>
                    </div>
                @else
                    <form wire:submit.prevent="processCheckout" class="checkout-form">
                        <button type="button" wire:click="$set('checkoutData.payment_method', '')" class="back-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                            </svg>
                            Back to Payment Methods
                        </button>

                        @if($checkoutData['payment_method'] === 'e-wallet')
                            <div class="payment-details">
                                <h4>E-Wallet Payment</h4>
                                <p>You will be redirected to Xendit to complete your payment using your preferred e-wallet.</p>
                                <div class="supported-wallets">
                                    <img src="{{ asset('images/gcash.png') }}" alt="GCash" class="wallet-icon">
                                    <img src="{{ asset('images/grabpay.png') }}" alt="GrabPay" class="wallet-icon">
                                    <img src="{{ asset('images/maya.png') }}" alt="Maya" class="wallet-icon">
                                </div>
                            </div>
                        @elseif($checkoutData['payment_method'] === 'card')
                            <div class="payment-details">
                                <h4>Card Payment</h4>
                                <p>Please enter your card details to proceed with the payment.</p>
                                <div class="card-inputs">
                                    <div class="form-group">
                                        <label for="card_number">Card Number</label>
                                        <input type="text" id="card_number" placeholder="1234 5678 9012 3456" required>
                                    </div>
                                    <div class="card-row">
                                        <div class="form-group">
                                            <label for="expiry">Expiry Date</label>
                                            <input type="text" id="expiry" placeholder="MM/YY" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="cvv">CVV</label>
                                            <input type="text" id="cvv" placeholder="123" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($checkoutData['payment_method'] === 'cash')
                            <div class="payment-details">
                                <h4>Cash Payment</h4>
                                <p>Please insert the bills and coins in the machine.</p>
                                <div class="cash-amount">
                                    <strong>Total Amount to Pay:</strong>
                                    <span class="amount">₱{{ number_format($total * 1.12, 2) }}</span>
                                </div>
                                <div class="inserted-amount" wire:poll.1s>
                                    <strong>Amount Inserted:</strong>
                                    <span class="amount">₱{{ number_format(session('inserted_total', 0), 2) }}</span>
                                </div>
                                <div class="remaining-amount">
                                    <strong>Remaining Amount:</strong>
                                    <span class="amount">₱{{ number_format(max(0, ($total * 1.12) - session('inserted_total', 0)), 2) }}</span>
                                </div>
                                @if(session('inserted_total', 0) >= ($total * 1.12))
                                    <div class="payment-complete">
                                        <p>Payment complete! Please wait for your receipt.</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <button type="submit" class="submit-order-btn">
                            @if($checkoutData['payment_method'] === 'e-wallet')
                                Pay with Xendit
                            @elseif($checkoutData['payment_method'] === 'card')
                                Pay with Card
                            @else
                                Place Order
                            @endif
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endif
</div>


