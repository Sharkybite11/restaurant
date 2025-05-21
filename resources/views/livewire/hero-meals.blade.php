<div class="menu-items-grid">
    @foreach($items as $item)
        <div class="menu-item-card">
            <div class="menu-item-image">
                <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="item-img">
            </div>
            <div class="details-container">
                <div class="menu-item-details">
                    <h3 class="item-name">{{ $item->name }}</h3>
                <div class="item-price">₱{{ number_format($item->price, 2) }}</div>
                </div>
                <button class="add-to-cart-btn" wire:click="$dispatch('add-to-cart', { itemId: {{ $item->id }}, category: 'heromeals' })">
                    <img src="{{ asset('images/ct3.png') }}" alt="Cart" class="ct3">
                </button>
            </div>
        </div>
    @endforeach
</div> 