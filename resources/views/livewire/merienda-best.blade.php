<div class="menu-items-grid">
    @foreach($items as $item)
        <div class="menu-item-card" wire:click="openItemModal({{ $item->id }})" style="cursor: pointer;">
            <div class="menu-item-image">
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="item-img">
            </div>
            <div class="details-container">
                <div class="menu-item-details">
                    <h3 class="item-name">{{ $item->name }}</h3>
                    <div class="item-price">₱{{ number_format($item->price, 2) }}</div>
                    <div class="item-quantity">Quantity: {{ $item->quantity }}</div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Item Modal -->
    @if($showItemModal)
        <div class="modal-overlay" wire:click="closeItemModal">
            <div class="modal-content" wire:click.stop>
                <div class="modal-header">
                    <h2>Item Details</h2>
                    <button wire:click="closeItemModal" class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    @if($selectedItem)
                        <div class="item-modal-content">
                            <div class="modal-item-image">
                                <img src="{{ asset($selectedItem->image_path) }}" alt="{{ $selectedItem->name }}" class="modal-img">
                            </div>
                            <div class="modal-item-details">
                                <h3 class="modal-item-name">{{ $selectedItem->name }}</h3>
                                <div class="modal-item-price">₱{{ number_format($selectedItem->price, 2) }}</div>
                                <div class="modal-item-quantity">Quantity: {{ $selectedItem->quantity }}</div>
                                <button class="add-to-cart-btn" wire:click="$dispatch('add-to-cart', { itemId: {{ $selectedItem->id }}, category: 'meriendabest' })">
                                    <img src="{{ asset('images/ct3.png') }}" alt="Cart" class="ct3">
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>


