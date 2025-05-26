<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar pesanan user yang login (atau admin).
     */
    public function index()
    {
        if (auth()->user()->is_admin) {
            $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        } else {
            $orders = Order::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan halaman checkout / buat pesanan baru.
     */
    public function create()
    {
        $carts = Cart::where('user_id', auth()->id())->with('menu')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('carts.index')->with('error', 'Keranjang belanja kosong.');
        }

        return view('orders.create', compact('carts'));
    }

    /**
     * Store a newly created resource in storage.
     * Simpan data pesanan baru dan item pesanan, kemudian hapus keranjang.
     */
    public function store(Request $request)
    {
        // Validasi tambahan jika ada, misal alamat, metode pembayaran, dll
        // $request->validate([...]);

        $userId = auth()->id();

        $carts = Cart::where('user_id', $userId)->with('menu')->get();

        if ($carts->isEmpty()) {
            return redirect()->route('carts.index')->with('error', 'Keranjang belanja kosong.');
        }

        DB::beginTransaction();

        try {
            // Hitung total harga pesanan
            $totalPrice = $carts->sum(fn($cart) => $cart->menu->price * $cart->quantity);

            // Buat kode order unik
            $orderCode = 'ORD-' . strtoupper(Str::random(8));

            // Simpan order
            $order = Order::create([
                'user_id' => $userId,
                'order_code' => $orderCode,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'total_price' => $totalPrice,
                'snap_token' => null, // jika integrasi Midtrans
            ]);

            // Simpan order items
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $cart->menu_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->menu->price,
                ]);
            }

            // Hapus semua item keranjang user
            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('carts.index')->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail pesanan.
     */
    public function show(Order $order)
    {
        if (!auth()->user()->is_admin && $order->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $order->load('items.menu', 'user');

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     * Biasanya untuk admin mengubah status pesanan.
     */
    public function edit(Order $order)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     * Update status pesanan.
     */
    public function update(Request $request, Order $order)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'status' => 'required|string',
            'payment_status' => 'required|string',
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Status pesanan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     * Hapus pesanan (hanya admin).
     */
    public function destroy(Order $order)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Akses ditolak.');
        }

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
