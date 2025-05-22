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
                    <div class="quantity-control">
                        @if($editingQuantityId === $item->id)
                            <div class="quantity-input-group">
                                <input type="number" 
                                       wire:model="quantities.{{ $item->id }}" 
                                       min="0" 
                                       class="quantity-input"
                                       wire:keydown.enter="updateQuantity({{ $item->id }})">
                                <button class="save-quantity-btn" 
                                        wire:click="updateQuantity({{ $item->id }})">
                                    Save
                                </button>
                                <button class="save-quantity-btn cancel-btn" wire:click="stopEditing()">Cancel</button>
                            </div>
                        @else
                            <button class="quantity-btn" 
                                    wire:click="startEditing({{ $item->id }})">
                                Quantity: {{ $item->quantity }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
