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
        
        // Cek apakah ini direct checkout dari halaman detail produk
        if ($request->has('direct_checkout') && $request->direct_checkout === 'true') {
            // Validasi data untuk direct checkout
            $request->validate([
                'menu_id' => 'required|exists:menus,id',
                'quantity' => 'required|integer|min:1',
            ]);
            
            DB::beginTransaction();
            
            try {
                // Ambil data menu
                $menu = \App\Models\Menu::findOrFail($request->menu_id);
                
                // Hitung total harga
                $totalPrice = $menu->price * $request->quantity;
                
                // Buat kode order unik
                $orderCode = 'ORD-' . strtoupper(Str::random(8));
                
                // Simpan order
                $order = Order::create([
                    'user_id' => $userId,
                    'order_code' => $orderCode,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'total_price' => $totalPrice,
                ]);
                
                // Simpan order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $request->menu_id,
                    'quantity' => $request->quantity,
                    'price' => $menu->price,
                    'notes' => $request->notes ?? '',
                ]);
                
                DB::commit();
                
                return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
            }
        } else {
            // Proses checkout dari keranjang
            // Cek apakah ada item yang dipilih
            if (!$request->has('selected_items') || empty($request->selected_items)) {
                return redirect()->route('carts.index')->with('error', 'Pilih minimal satu produk untuk checkout.');
            }
            
            // Ambil ID cart yang dipilih
            $selectedCartIds = explode(',', $request->selected_items);
            
            // Ambil cart yang dipilih
            $carts = Cart::whereIn('id', $selectedCartIds)
                ->where('user_id', $userId)
                ->with('menu')
                ->get();
            
            if ($carts->isEmpty()) {
                return redirect()->route('carts.index')->with('error', 'Keranjang belanja kosong atau produk tidak ditemukan.');
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
                    'payment_status' => 'pending',
                    'total_price' => $totalPrice,
                ]);
                
                // Simpan order items
                foreach ($carts as $cart) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_id' => $cart->menu_id,
                        'quantity' => $cart->quantity,
                        'price' => $cart->menu->price,
                        'notes' => $cart->notes ?? '',
                    ]);
                }
                
                // Hapus item keranjang yang dipilih
                Cart::whereIn('id', $selectedCartIds)->where('user_id', $userId)->delete();
                
                DB::commit();
                
                return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('carts.index')->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
            }
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

/**
 * Update payment status by admin
 */
public function updatePayment(Request $request, Order $order)
{
    if (!auth()->user()->is_admin) {
        abort(403, 'Akses ditolak.');
    }

    $request->validate([
        'payment_status' => 'required|in:pending,success,failed,cancelled',
    ]);

    // Map payment status to order status
    $orderStatusMap = [
        'pending' => 'pending',
        'success' => 'confirmed',
        'failed' => 'cancelled',
        'cancelled' => 'cancelled'
    ];

    $order->update([
        'payment_status' => $request->payment_status,
        'status' => $orderStatusMap[$request->payment_status]
    ]);

    $statusMessages = [
        'pending' => 'Status pembayaran direset ke pending.',
        'success' => 'Pembayaran dikonfirmasi berhasil.',
        'failed' => 'Pembayaran ditandai gagal.',
        'cancelled' => 'Pembayaran dibatalkan.'
    ];

    $message = $statusMessages[$request->payment_status] ?? 'Status pembayaran berhasil diupdate.';

    return redirect()->back()->with('success', $message);
}

/**
 * Reorder - add order items back to cart
 */
public function reorder(Order $order)
{
    if (!auth()->check() || (!auth()->user()->is_admin && $order->user_id !== auth()->id())) {
        abort(403, 'Akses ditolak.');
    }

    if ($order->payment_status !== 'success') {
        return redirect()->back()->with('error', 'Hanya pesanan yang berhasil yang bisa dipesan ulang.');
    }

    foreach ($order->items as $item) {
        Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'menu_id' => $item->menu_id
            ],
            [
                'quantity' => DB::raw('quantity + ' . $item->quantity)
            ]
        );
    }

    return redirect()->route('carts.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}


}
