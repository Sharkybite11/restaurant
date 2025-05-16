<div class="menu-container">
    <div class="order-type-banner {{ $type }}" style="background-image: url('{{ asset('images/banner.png') }}');">
        <img src="{{ asset('images/diner.png') }}" alt="Logo" class="diner-banner">
        <img src="{{ asset('images/lg.png') }}" alt="Logo" class="logo-banner">
    </div>
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
        @endif
    </div>
</div>
