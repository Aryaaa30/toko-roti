<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Tampilkan semua item dalam keranjang pengguna.
     */
    public function index()
    {
        $carts = Cart::with('menu')
            ->where('user_id', auth()->id())
            ->get();

        return view('carts.cart', compact('carts'));
    }

    /**
     * Tambahkan item ke keranjang.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $userId = auth()->id();
        $menuId = $request->menu_id;
        $quantity = $request->input('quantity', 1);

        $cart = Cart::where('user_id', $userId)
                    ->where('menu_id', $menuId)
                    ->first();

        if ($cart) {
            // Jika sudah ada, tambahkan jumlah
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            // Jika belum ada, buat entri baru
            Cart::create([
                'user_id' => $userId,
                'menu_id' => $menuId,
                'quantity' => $quantity,
            ]);
        }

        // Get updated cart count for notification
        $cartCount = Cart::where('user_id', $userId)->sum('quantity');

        // Cek apakah request adalah AJAX/JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke keranjang!',
                'cartCount' => $cartCount
            ], 200);
        }

        // Jika bukan JSON, redirect biasa
        return redirect()->route('carts.index')
            ->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }

    /**
     * Perbarui jumlah item dalam keranjang.
     */
    public function update(Request $request, Cart $cart)
    {
        // Cek kepemilikan
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update([
            'quantity' => $request->quantity
        ]);

        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

        if ($request->expectsJson()) {
    return response()->json([
        'success' => true,
                'message' => 'Jumlah item berhasil diperbarui!',
                'cartCount' => $cartCount
    ]);
}

        return redirect()->route('carts.index')
            ->with('success', 'Jumlah item berhasil diperbarui!');
}

    /**
     * Hapus item dari keranjang.
     */
    public function destroy(Cart $cart)
    {
        // Cek kepemilikan
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $cart->delete();

        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus dari keranjang!',
                'cartCount' => $cartCount
            ]);
        }

        return redirect()->route('carts.index')
            ->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($id);

        // Cek kepemilikan
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

        return response()->json([
            'success' => true,
            'total' => $cart->menu->price * $cart->quantity,
            'cartCount' => $cartCount
        ]);
    }

    /**
     * Get current cart count
     */
    public function getCartCount()
    {
        $cartCount = 0;

        if (auth()->check()) {
            $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
        }

        return response()->json([
            'cartCount' => $cartCount
        ]);
    }
}
