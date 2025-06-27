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
    Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');

    // Keranjang belanja (hanya method index, store, update, destroy)
    Route::resource('carts', CartController::class)->only(['index', 'store', 'update', 'destroy']);
    
    // Get cart count for real-time update
    Route::get('/cart-count', [CartController::class, 'getCartCount'])->name('cart.count');
});

// Cart routes yang memerlukan autentikasi
Route::middleware('cart.auth')->group(function() {
    Route::put('/carts/{id}/quantity', [CartController::class, 'updateQuantity'])->name('carts.updateQuantity');
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');

    Route::put('/orders/{order}/update-address', [OrderController::class, 'updateAddress'])->name('orders.update_address');
    Route::patch('/orders/{order}/payment', [OrderController::class, 'updatePayment'])->name('orders.updatePayment');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
});



// Routes yang dapat diakses tanpa login
Route::resource('menus', MenuController::class)->only(['index', 'show']);
Route::get('/bakeries', [MenuController::class, 'bakeries'])->name('bakeries');
Route::get('/categories', [MenuController::class, 'categories'])->name('categories');
// Birthday routes with role-based access
Route::get('/birthday', [BirthdayController::class, 'index'])->name('birthday');
Route::get('/birthday/admin', [BirthdayController::class, 'adminPage'])->middleware(['auth', 'admin'])->name('birthday.admin');
Route::get('/birthday/user', [BirthdayController::class, 'userPage'])->middleware(['auth'])->name('birthday.user');
Route::get('/birthday/create', [BirthdayController::class, 'create'])->middleware(['auth', 'admin'])->name('birthday.create');
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
    Route::get('/admin/konfirmasi', [App\Http\Controllers\AdminController::class, 'konfirmasi'])->name('admin.konfirmasi');
    Route::get('/admin/reviews', [App\Http\Controllers\AdminController::class, 'reviewAdmin'])->name('admin.reviews');
    Route::get('/admin/menu', [App\Http\Controllers\AdminController::class, 'menuAdmin'])->name('admin.menu');
});

// Route khusus untuk pelanggan
Route::middleware('auth')->group(function () {
    Route::get('/customer/reviews', function(\Illuminate\Http\Request $request) {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.reviews');
        }
        
        $menu_id = $request->get('menu_id');
        if (!$menu_id) {
            // Jika tidak ada menu_id, redirect ke halaman menu
            return redirect()->route('menus.index')->with('info', 'Silakan pilih menu yang ingin direview.');
        }
        
        $menu = \App\Models\Menu::find($menu_id);
        
        if (!$menu) {
            return redirect()->route('menus.index')->with('error', 'Menu tidak ditemukan.');
        }
        
        // Ambil hanya review untuk menu yang dipilih
        $reviews = \App\Models\Review::where('menu_id', $menu->id)
            ->with(['user', 'menu'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('reviews.review', compact('reviews', 'menu'));
    })->name('customer.reviews');
    
    // Route untuk customer menambahkan review
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Route untuk mengambil alamat user via AJAX
Route::middleware('auth')->get('/user/addresses', [\App\Http\Controllers\AddressController::class, 'index'])->name('user.addresses');

// Route untuk menyimpan alamat baru
Route::middleware('auth')->post('/addresses', [\App\Http\Controllers\AddressController::class, 'store'])->name('addresses.store');

// Route untuk menghapus alamat
Route::middleware('auth')->delete('/addresses/{address}', [\App\Http\Controllers\AddressController::class, 'destroy'])->name('addresses.destroy');

require __DIR__.'/auth.php';