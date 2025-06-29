<?php

use Illuminate\Support\Facades\Route;

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

// Staff Console routes
Route::get('/staff-console', StaffConsole::class)->name('staff.console');
Route::get('/staff-console/{type}', StaffConsole::class)->name('staff.console.type')
    ->where('type', 'dine-in|to-go');

// Money insertion routes
Route::post('/money/update', [App\Http\Controllers\MoneyInsertionController::class, 'updateInsertedAmount']);
Route::post('/money/reset', [App\Http\Controllers\MoneyInsertionController::class, 'resetInsertedAmount']);

// Fallback route for 404s
Route::fallback(function () {
    return redirect()->route('home');
});
