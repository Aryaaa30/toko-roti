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
            $orders = Order::with(['items.menu', 'user'])->latest()->get();
        } else {
            $orders = Order::with(['items.menu', 'user'])
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
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
    try {
        $order = Order::with('items.menu')->findOrFail($id);

        // Cek jika pesanan sudah dibayar
    if ($order->payment_status === 'paid') {
            return response()->json([
                'error' => 'Pesanan ini sudah dibayar'
            ], 400);
    }

        // Setup konfigurasi Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

        // Log untuk debugging
        \Log::info('Midtrans config:', [
            'server_key_exists' => !empty(config('midtrans.server_key')),
            'is_production' => config('midtrans.is_production'),
                'order_id' => $order->order_code,
            'amount' => $order->total_price
        ]);

        // Persiapkan item details untuk Midtrans
        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'id' => $item->id,
                'price' => (int)$item->price,
                'quantity' => (int)$item->quantity,
                'name' => substr($item->menu->name, 0, 50), // Batasi nama produk (max 50 char)
    ];
        }

        $user = auth()->user();

        // Pastikan gross_amount minimal Rp 10.000 untuk testing di sandbox
        // Dan pastikan nilainya integer (bukan string atau float)
        $grossAmount = max((int)$order->total_price, 10000);

        // Parameter transaksi untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $user->name ?? 'Customer',
                'email' => $user->email ?? 'customer@example.com',
                'phone' => $user->phone ?? '08123456789',
                'shipping_address' => [
                    'address' => $order->shipping_address ?? 'Alamat default'
                ],
            ],
            'callbacks' => [
                'finish' => config('midtrans.finish_redirect_url'),
                'error' => config('midtrans.error_redirect_url'),
                'unfinish' => config('midtrans.unfinish_redirect_url'),
            ],
        ];

        // Log parameter yang dikirim ke Midtrans
        \Log::info('Midtrans params:', $params);
        // Dapatkan Snap Token dari Midtrans
    $snapToken = Snap::getSnapToken($params);

        // Log snap token yang diterima
        \Log::info('Midtrans snap token received:', ['token' => $snapToken]);
        // Simpan snap token ke order
    $order->update(['snap_token' => $snapToken]);

        return response()->json([
            'snap_token' => $snapToken
        ]);
    } catch (\Exception $e) {
        // Log error untuk debugging
        \Log::error('Midtrans getSnapToken error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

        return response()->json([
            'error' => 'Gagal mengambil token pembayaran: ' . $e->getMessage()
        ], 500);
}
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
