<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

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

        return view('orders.order', compact('orders'));
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

        return view('orders.detail', compact('order'));
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

    public function getSnapToken($id)
{
    $order = Order::with('items.menu')->findOrFail($id);

    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $items = [];

    foreach ($order->items as $item) {
        $items[] = [
            'id' => $item->id,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'name' => $item->menu->name,
        ];
    }

    $params = [
        'transaction_details' => [
            'order_id' => $order->order_code,
            'gross_amount' => $order->total_price,
        ],
        'item_details' => $items,
        'customer_details' => [
            'first_name' => 'Customer',
            'email' => 'customer@example.com',
            'phone' => '08123456789',
            'shipping_address' => [
                'address' => $order->shipping_address
            ],
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    return response()->json([
        'snap_token' => $snapToken
    ]);
}

public function updateAddress(Request $request, Order $order)
{
    if (!auth()->user()->is_admin && $order->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'shipping_address' => 'required|string|max:255',
    ]);

    $order->update([
        'shipping_address' => $request->shipping_address,
    ]);

    return redirect()->back()->with('success', 'Alamat berhasil diperbarui.');
}

public function pay(Request $request, Order $order)
{
    if (!auth()->user()->is_admin && $order->user_id !== auth()->id()) {
        abort(403, 'Akses ditolak.');
    }

    // Validasi: pastikan pesanan belum dibayar
    if ($order->payment_status === 'paid') {
        return redirect()->back()->with('info', 'Pesanan sudah dibayar.');
    }

    // Konfigurasi Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // Persiapkan item details
    $items = [];
    foreach ($order->items as $item) {
        $items[] = [
            'id' => $item->id,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'name' => $item->menu->name,
        ];
    }

    // Customer details
    $customerDetails = [
        'first_name' => auth()->user()->name,
        'email' => auth()->user()->email,
        'phone' => auth()->user()->phone ?? '08123456789',
        'shipping_address' => [
            'address' => $order->shipping_address ?? 'Alamat belum diisi',
        ],
    ];

    // Parameter transaksi Midtrans
    $params = [
        'transaction_details' => [
            'order_id' => $order->order_code,
            'gross_amount' => $order->total_price,
        ],
        'item_details' => $items,
        'customer_details' => $customerDetails,
    ];

    // Dapatkan Snap Token
    $snapToken = Snap::getSnapToken($params);

    // Simpan Snap Token ke DB (kalau mau)
    $order->update(['snap_token' => $snapToken]);

    // Redirect atau tampilkan view pembayaran (pakai Snap JS di front-end)
    return view('orders.payment', compact('order', 'snapToken'));
}


}
