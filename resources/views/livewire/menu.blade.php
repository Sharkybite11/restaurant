<div class="menu-container">
    <div class="order-type-banner {{ $type }}">
        <img src="{{ asset('images/diner.png') }}" alt="Logo" class="diner-banner">
        <img src="{{ asset('images/lg.png') }}" alt="Logo" class="logo-banner">
    </div>
    <div class="categories-section">
        <div class="categories-scroll">
            <button class="category-btn {{ $selectedCategory === 'all' ? 'active' : '' }}" 
                    wire:click="selectCategory('all')">All Items</button>
            <button class="category-btn {{ $selectedCategory === 'meriendabest' ? 'active' : '' }}" 
                    wire:click="selectCategory('meriendabest')">Merienda Best</button>
            <button class="category-btn">Budget Meals</button>
            <button class="category-btn">Hero Meals</button>
            <button class="category-btn">Combusog</button>
            <button class="category-btn">Platter</button>
            <button class="category-btn">Drinks</button>
        </div>
    </div>
    <div class="menu-items">
        @if($selectedCategory === 'meriendabest')
            <livewire:merienda-best />
        @endif
    </div>
</div>
