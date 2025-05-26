<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar order item (bisa untuk admin).
     */
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'menu'])->orderBy('created_at', 'desc')->get();
        return view('orderitems.index', compact('orderItems'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form tambah order item (jarang dipakai).
     */
    public function create()
    {
        $orders = Order::all();
        $menus = Menu::all();
        return view('orderitems.create', compact('orders', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     * Simpan order item baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        OrderItem::create($request->all());

        return redirect()->route('orderitems.index')->with('success', 'Order item berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail order item.
     */
    public function show(OrderItem $orderitem)
    {
        $orderitem->load('order', 'menu');
        return view('orderitems.show', compact('orderitem'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form edit order item.
     */
    public function edit(OrderItem $orderitem)
    {
        $orders = Order::all();
        $menus = Menu::all();
        return view('orderitems.edit', compact('orderitem', 'orders', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     * Update order item.
     */
    public function update(Request $request, OrderItem $orderitem)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $orderitem->update($request->all());

        return redirect()->route('orderitems.index')->with('success', 'Order item berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     * Hapus order item.
     */
    public function destroy(OrderItem $orderitem)
    {
        $orderitem->delete();

        return redirect()->route('orderitems.index')->with('success', 'Order item berhasil dihapus.');
    }
}
