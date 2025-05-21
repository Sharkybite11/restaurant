<div class="menu-container" x-data x-on:add-to-cart.window="$wire.addToCart($event.detail.itemId, $event.detail.category)">
    
    <div class="order-type-banner {{ $type }}" style="background-image: url('{{ asset('images/banner.png') }}');">
        <img src="{{ asset('images/diner.png') }}" alt="Logo" class="diner-banner">
        <img src="{{ asset('images/lg.png') }}" alt="Logo" class="logo-banner">
    </div>

    <div class="search-section">
        <div class="search-container">
            <input type="text" 
                   wire:model.live="search" 
                   placeholder="Search menu items..." 
                   class="search-input">
            @if($search)
                <button wire:click="$set('search', '')" class="clear-search">×</button>
            @endif
            <button class="category-btn {{ $selectedCategory === 'cart' ? 'active' : '' }}" wire:click="selectCategory('cart')">
                <img src="{{ asset('images/ct1.png') }}" alt="Cart" class="cart-icon"></button>
        </div>
    </div>

    @if($search)
        <div class="search-results">
            <h2>Search Results</h2>
            <div class="menu-items-grid">
                @foreach($searchResults as $item)
                    <div class="menu-item-card">
                        <div class="menu-item-image">
                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="item-img">
                        </div>
                        <div class="details-container">
                            <div class="menu-item-details">
                                <h3 class="item-name">{{ $item->name }}</h3>
                                <div class="item-category">{{ $item->category }}</div>
                                <div class="item-price">₱{{ number_format($item->price, 2) }}</div>
                            </div>
                            <button class="add-to-cart-btn" wire:click="addToCart({{ $item->id }}, '{{ strtolower(str_replace(' ', '', $item->category)) }}')">
                                <img src="{{ asset('images/ct3.png') }}" alt="Cart" class="ct3">
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="categories-section">
            <div class="categories-scroll">
                <button class="category-btn {{ $selectedCategory === 'meriendabest' ? 'active' : '' }}" 
                        wire:click="selectCategory('meriendabest')">Merienda Best</button>
                <button class="category-btn {{ $selectedCategory === 'budgetmeals' ? 'active' : '' }}" wire:click="selectCategory('budgetmeals')">Budget Meals</button>
                <button class="category-btn {{ $selectedCategory === 'heromeals' ? 'active' : '' }}" wire:click="selectCategory('heromeals')">Hero Meals</button>
                <button class="category-btn {{ $selectedCategory === 'combusog' ? 'active' : '' }}" wire:click="selectCategory('combusog')">Combusog</button>
                <button class="category-btn {{ $selectedCategory === 'platter' ? 'active' : '' }}" wire:click="selectCategory('platter')">Platter</button>
                <button class="category-btn {{ $selectedCategory === 'drinks' ? 'active' : '' }}" wire:click="selectCategory('drinks')">Drinks</button>
            </div>
        </div>
        <div class="menu-items">
            @if($selectedCategory === 'meriendabest')
                <livewire:merienda-best />
            @elseif($selectedCategory === 'budgetmeals')
                <livewire:budget-meals />
            @elseif($selectedCategory === 'heromeals')
                <livewire:hero-meals />
            @elseif($selectedCategory === 'combusog')
                <livewire:combusog-menu />
            @elseif($selectedCategory === 'platter')
                <livewire:platter-menu-livewire />
            @elseif($selectedCategory === 'drinks')
                <livewire:drinks />
            @elseif($selectedCategory === 'cart')
                <livewire:cart />
            @endif
        </div>
    @endif
</div>
