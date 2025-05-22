<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\XenditWebhookController;

use App\Livewire\Logo;
use App\Livewire\Menu;
use App\Livewire\Cart;
use App\Livewire\StaffConsole;

// Home/Landing page
Route::get('/', Logo::class)->name('home');

// Menu routes with type parameter
Route::get('/menu', Menu::class)->name('menu');
Route::get('/menu/{type}', Menu::class)->name('menu.type')
    ->where('type', 'dine-in|to-go');

// Cart route
Route::get('/cart', Cart::class)->name('cart');

// Payment routes
Route::get('/payment/success', function () {
    session()->flash('success', 'Payment successful! Thank you for your order.');
    return redirect()->route('home');
})->name('payment.success');

Route::get('/payment/failure', function () {
    session()->flash('error', 'Payment failed. Please try again.');
    return redirect()->route('cart');
})->name('payment.failure');

// Xendit webhook route
Route::post('/webhook/xendit', [XenditWebhookController::class, 'handle'])->name('webhook.xendit');

// Staff Console routes
Route::get('/staff-console', StaffConsole::class)->name('staff.console');
Route::get('/staff-console/{type}', StaffConsole::class)->name('staff.console.type')
    ->where('type', 'dine-in|to-go');

// Fallback route for 404s
Route::fallback(function () {
    return redirect()->route('home');
});
