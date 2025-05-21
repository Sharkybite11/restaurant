<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Logo;
use App\Livewire\Menu;
use App\Livewire\Cart;

// Home/Landing page
Route::get('/', Logo::class)->name('home');

// Menu routes with type parameter
Route::get('/menu', Menu::class)->name('menu');
Route::get('/menu/{type}', Menu::class)->name('menu.type')
    ->where('type', 'dine-in|to-go');

// Cart route
Route::get('/cart', Cart::class)->name('cart');

// Fallback route for 404s
Route::fallback(function () {
    return redirect()->route('home');
});
