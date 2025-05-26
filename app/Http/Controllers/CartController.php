<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan daftar item di keranjang user.
     */
    public function index()
    {
        $carts = Cart::with('menu')->where('user_id', auth()->id())->get();
        return view('carts.index', compact('carts'));
    }

    /**
     * Menambahkan item ke keranjang.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $request->quantity ?? 1;

        $cart = Cart::where('user_id', auth()->id())
                    ->where('menu_id', $request->menu_id)
                    ->first();

        if ($cart) {
            // Tambah quantity jika sudah ada
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            // Buat item baru
            Cart::create([
                'user_id' => auth()->id(),
                'menu_id' => $request->menu_id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('carts.index')->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update quantity item di keranjang.
     */
    public function update(Request $request, Cart $cart)
    {
        // Pastikan user hanya bisa update item miliknya
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('carts.index')->with('success', 'Keranjang berhasil diupdate!');
    }

    /**
     * Hapus item dari keranjang.
     */
    public function destroy(Cart $cart)
    {
        // Pastikan user hanya bisa hapus item miliknya
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $cart->delete();

        return redirect()->route('carts.index')->with('success', 'Item berhasil dihapus dari keranjang!');
    }
}
