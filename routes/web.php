<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\OrderItemController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Menu (bisa diakses oleh semua user yang login)
    Route::resource('menus', MenuController::class);
    Route::resource('orders', OrderController::class);


    // Keranjang belanja (hanya method index, store, update, destroy)
    Route::resource('carts', CartController::class)->only(['index', 'store', 'update', 'destroy']);
});

Route::put('/carts/{id}/quantity', [CartController::class, 'updateQuantity'])->name('carts.updateQuantity');
Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
Route::get('/orders/{order}/getSnapToken', [OrderController::class, 'getSnapToken'])->name('orders.getSnapToken');
Route::put('/orders/{order}/update-address', [OrderController::class, 'updateAddress'])->name('orders.update_address');
Route::get('/cart', [CartController::class, 'index'])->name('cart');


// Route khusus admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('reviews', ReviewController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('orderitems', OrderItemController::class);
});

require __DIR__.'/auth.php';
