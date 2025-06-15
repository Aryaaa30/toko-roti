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
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\SimpleMidtransController;
use App\Http\Controllers\BirthdayController;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    // Get most ordered menus (best sellers) for the home page
    $menus = Menu::select('menus.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
        ->leftJoin('order_items', 'menus.id', '=', 'order_items.menu_id')
        ->leftJoin('orders', function($join) {
            $join->on('orders.id', '=', 'order_items.order_id')
                 ->where('orders.status', 'completed');
        })
        ->where('menus.available', 1)
        ->groupBy('menus.id')
        ->orderBy('total_sold', 'desc')
        ->with('reviews')
        ->get();
    return view('home', compact('menus'));
})->name('landing');

Route::middleware('auth')->group(function () {
    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Menu yang memerlukan login (create, edit, update, destroy)
    Route::resource('menus', MenuController::class)->except(['index', 'show']);
    
    // Orders memerlukan login
    Route::resource('orders', OrderController::class);

    // Keranjang belanja (hanya method index, store, update, destroy)
    Route::resource('carts', CartController::class)->only(['index', 'store', 'update', 'destroy']);
    
    // Get cart count for real-time update
    Route::get('/cart-count', [CartController::class, 'getCartCount'])->name('cart.count');
});

// Cart routes yang memerlukan autentikasi
Route::middleware('cart.auth')->group(function() {
    Route::put('/carts/{id}/quantity', [CartController::class, 'updateQuantity'])->name('carts.updateQuantity');
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::get('/orders/{order}/getSnapToken', [OrderController::class, 'getSnapToken'])->name('orders.getSnapToken');
    Route::put('/orders/{order}/update-address', [OrderController::class, 'updateAddress'])->name('orders.update_address');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
});

// Midtrans routes
Route::prefix('midtrans')->group(function() {
    Route::get('/finish', [MidtransController::class, 'finishRedirect'])->name('midtrans.finish');
    Route::get('/unfinish', [MidtransController::class, 'finishRedirect'])->name('midtrans.unfinish');
    Route::get('/error', [MidtransController::class, 'failRedirect'])->name('midtrans.error');

    // Tambahkan rute untuk SimpleMidtransController
    Route::get('/test', [SimpleMidtransController::class, 'testPaymentPage'])->name('midtrans.test');
    Route::post('/get-test-token', [SimpleMidtransController::class, 'getTestToken'])->name('midtrans.get-test-token');
    Route::get('/checkout/{order}', [SimpleMidtransController::class, 'directCheckout'])->name('midtrans.direct-checkout');
});

// Routes yang dapat diakses tanpa login
Route::resource('menus', MenuController::class)->only(['index', 'show']);
Route::get('/bakeries', [MenuController::class, 'bakeries'])->name('bakeries');
Route::get('/categories', [MenuController::class, 'categories'])->name('categories');
// Birthday routes with role-based access
Route::get('/birthday', [BirthdayController::class, 'index'])->name('birthday');
Route::get('/birthday/admin', [BirthdayController::class, 'adminPage'])->middleware(['auth', 'admin'])->name('birthday.admin');
Route::get('/birthday/user', [BirthdayController::class, 'userPage'])->middleware(['auth'])->name('birthday.user');
Route::get('/about', function() {
    return view('about_us');
})->name('about');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/api/search', [SearchController::class, 'searchApi'])->name('search.api');
Route::get('/account', function () {
    return view('profiles.account'); // Pastikan file ini ada di resources/views/profiles/account.blade.php
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