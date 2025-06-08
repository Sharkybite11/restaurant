<div class="menu-container" x-data="{ editingQuantity: null }">
    <style>
        .staff-title {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin: 0;
            padding: 10px;
        }
        
        .quantity-control {
            margin-top: 10px;
        }
        
        .quantity-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .quantity-btn:hover {
            background-color: #45a049;
        }
        
        .quantity-input-group {
            display: flex;
            gap: 5px;
            align-items: center;
        }
        
        .quantity-input {
            width: 80px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .save-quantity-btn {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .save-quantity-btn:hover {
            background-color: #1976D2;
        }
        </style> 
    <div class="order-type-banner staff" style="background-image: url('{{ asset('images/banner.png') }}');">
        <img src="{{ asset('images/diner.png') }}" alt="Logo" class="diner-banner">
        <img src="{{ asset('images/lg.png') }}" alt="Logo" class="logo-banner">
        <h1 class="staff-title">Staff Console</h1>
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
                                <div class="quantity-control">
                                    @if($editingQuantity === $item->id)
                                        <div class="quantity-input-group">
                                            <input type="number" 
                                                   wire:model="quantities.{{ $item->id }}" 
                                                   min="0" 
                                                   class="quantity-input"
                                                   wire:keydown.enter="updateQuantity({{ $item->id }}, '{{ strtolower(str_replace(' ', '', $item->category)) }}')">
                                            <button class="save-quantity-btn" 
                                                    wire:click="updateQuantity({{ $item->id }}, '{{ strtolower(str_replace(' ', '', $item->category)) }}')">
                                                Save
                                            </button>
                                        </div>
                                    @else
                                        <button class="quantity-btn" 
                                                wire:click="$set('editingQuantity', {{ $item->id }})">
                                            Quantity: {{ $item->quantity }}
                                        </button>
                                    @endif
                                </div>
                            </div>
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
                <button class="category-btn {{ $selectedCategory === 'budgetmeals' ? 'active' : '' }}" 
                        wire:click="selectCategory('budgetmeals')">Budget Meals</button>
                <button class="category-btn {{ $selectedCategory === 'heromeals' ? 'active' : '' }}" 
                        wire:click="selectCategory('heromeals')">Hero Meals</button>
                <button class="category-btn {{ $selectedCategory === 'combusog' ? 'active' : '' }}" 
                        wire:click="selectCategory('combusog')">Combusog</button>
                <button class="category-btn {{ $selectedCategory === 'platter' ? 'active' : '' }}" 
                        wire:click="selectCategory('platter')">Platter</button>
                <button class="category-btn {{ $selectedCategory === 'drinks' ? 'active' : '' }}" 
                        wire:click="selectCategory('drinks')">Drinks</button>
                <button class="category-btn {{ $selectedCategory === 'orders' ? 'active' : '' }}" 
                        wire:click="selectCategory('orders')">Orders</button>
            </div>
        </div>
        <div class="menu-items">
            @if($selectedCategory === 'meriendabest')
                <livewire:staff-merienda-best />
            @elseif($selectedCategory === 'budgetmeals')
                <livewire:staff-budget-meals />
            @elseif($selectedCategory === 'heromeals')
                <livewire:staff-hero-meals />
            @elseif($selectedCategory === 'combusog')
                <livewire:staff-combusog-menu />
            @elseif($selectedCategory === 'platter')
                <livewire:staff-platter-menu />
            @elseif($selectedCategory === 'drinks')
                <livewire:staff-drinks />
            @elseif($selectedCategory === 'orders')
                <livewire:staff-orders />
            @endif
        </div>
    @endif

    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Staff Console</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Cash Payments Section -->
            <div class="bg-gray-100 rounded-lg p-4">
                <livewire:cash-payments />
            </div>
            
            <!-- Other sections can be added here -->
        </div>
    </div>
</div>

