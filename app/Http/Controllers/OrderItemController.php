<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Menampilkan daftar order item.
     */
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'menu'])->orderBy('created_at', 'desc')->get();
        return view('orderitems.order_item', compact('orderItems'));
    }

    /**
     * Menampilkan form tambah order item.
     */
    public function create()
    {
        $orders = Order::all();
        $menus = Menu::all();
        return view('orderitems.create', compact('orders', 'menus'));
    }

    /**
     * Simpan order item baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        $orderItem = new OrderItem();
        $orderItem->order_id = $request->order_id;
        $orderItem->menu_id = $menu->id;
        $orderItem->quantity = $request->quantity;
        $orderItem->price = $request->price;

        // Simpan nama dan gambar menu saat ini ke order item (agar tidak berubah jika menu diubah)
        $orderItem->name = $menu->name;
        $orderItem->image_url = $menu->image_url;

        $orderItem->save();

        return redirect()->route('orderitems.index')->with('success', 'Order item berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail dari order item.
     */
    public function show(OrderItem $orderitem)
    {
        $orderitem->load('order', 'menu');
        return view('orderitems.show', compact('orderitem'));
    }

    /**
     * Menampilkan form edit order item.
     */
    public function edit(OrderItem $orderitem)
    {
        $orders = Order::all();
        $menus = Menu::all();
        return view('orderitems.edit', compact('orderitem', 'orders', 'menus'));
    }

    /**
     * Proses update order item.
     */
    public function update(Request $request, OrderItem $orderitem)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        $orderitem->order_id = $request->order_id;
        $orderitem->menu_id = $menu->id;
        $orderitem->quantity = $request->quantity;
        $orderitem->price = $request->price;

        // Update nama dan gambar jika menu berubah
        $orderitem->name = $menu->name;
        $orderitem->image_url = $menu->image_url;

        $orderitem->save();

        return redirect()->route('orderitems.index')->with('success', 'Order item berhasil diupdate.');
    }

    /**
     * Menghapus order item dari database.
     */
    public function destroy(OrderItem $orderitem)
    {
        $orderitem->delete();

        return redirect()->route('orderitems.index')->with('success', 'Order item berhasil dihapus.');
    }

}