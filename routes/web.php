<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Models\Menu;


Route::get('/', function () {
    $menus = Menu::with('reviews')->get();
    return view('home', compact('menus'));
});


Route::get('/home', function () {
    $menus = Menu::with('reviews')->get();
    return view('home', compact('menus'));
});


Route::get('/dashboard', [MenuController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


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

Route::get('/bakeries', [MenuController::class, 'bakeries'])->name('bakeries');
Route::get('/categories', [MenuController::class, 'categories'])->name('categories');
Route::get('/birthday', [MenuController::class, 'birthday'])->name('birthday');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/account', function () {
    return view('profiles.account'); // Pastikan file ini ada di resources/views/account.blade.php
})->middleware(['auth'])->name('account.page');

Route::get('/account/settings', function () {
    return view('profiles.settings');
})->name('account.settings');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/home');
})->name('logout');

Route::middleware('auth')->group(function() {
    Route::post('/user/changePassword', [UserController::class, 'changePassword'])->name('user.changePassword');
});

Route::post('/account/update-profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
Route::post('/account/upload-profile-picture', [UserController::class, 'uploadProfilePicture'])->name('account.uploadProfilePicture');



// Route khusus admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('reviews', ReviewController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('orderitems', OrderItemController::class);
});

require __DIR__.'/auth.php';
