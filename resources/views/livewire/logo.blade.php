<div class="logo-page">
    <img src="{{ asset('images/back.jpg') }}" alt="Background" class="background-img">
    <div class="logo-container">
        <!-- Logo Display Section -->
        <div class="logo-display">
            <img src="{{ asset('images/lg.png') }}" alt="Restaurant Logo" class="logo-image">
        </div>
        <div class="start-order">
            <img src="{{ asset('images/Start.png') }}" alt="Start Order" class="start-order-img">
            <img src="{{ asset('images/Order.png') }}" alt="Order" class="order-img">
        </div>
        <div class="button-container">
            <button class="logo-button" id="mainButton">
                <img src="{{ asset('images/arrow.png') }}" alt="arrow" class="arrow-img">
            </button>
            <div class="split-buttons" style="display: none;">
                <button class="logo-button dine-in">
                   <img src="{{ asset('images/utensils.png') }}" alt="Dine In" class="dine-in-img"> <img src="{{ asset('images/dine.png') }}" alt="Dine In" class="dine-in-img">
                </button>
                <button class="logo-button to-go">
                    <img src="{{ asset('images/run.png') }}" alt="To Go" class="to-go-img"> <img src="{{ asset('images/togo.png') }}" alt="To Go" class="to-go-img">
                </button>
            </div>
        </div>
    </div>
    <div class="footer-text">
        Tap to order. All major credit/debit cards, GCash, Maya, and contactless payments accepted. Prices inclusive of VAT. Receipt will be printed upon completion of transaction. For assistance, please approach our staff.
        
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainButton = document.getElementById('mainButton');
        const splitButtons = document.querySelector('.split-buttons');

        mainButton.addEventListener('click', function() {
            mainButton.style.display = 'none';
            splitButtons.style.display = 'flex';
        });

        document.querySelector('.dine-in').addEventListener('click', function() {
            // Add your dine-in logic here
            window.location.href = '/menu?type=dine-in';
        });

        document.querySelector('.to-go').addEventListener('click', function() {
            // Add your to-go logic here
            window.location.href = '/menu?type=to-go';
        });
    });
</script>
