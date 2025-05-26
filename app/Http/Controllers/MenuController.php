<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function __construct()
    {
        // Batasi akses method tertentu hanya untuk admin
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Tampilkan daftar menu.
     * Admin lihat semua, user lihat yang tersedia saja.
     */
    public function index()
    {
        if (auth()->user()->is_admin) {
            $menus = Menu::all();
            return view('menus.admin_index', compact('menus'));
        } else {
            $menus = Menu::all();
            return view('menus.user_index', compact('menus'));
        }
    }

    /**
     * Tampilkan detail menu (opsional).
     */
    public function show(Menu $menu)
    {
        if (!auth()->user()->is_admin && !$menu->available) {
            abort(403, 'Menu tidak tersedia.');
        }
        return view('menus.show', compact('menu'));
    }

    /**
     * Tampilkan form tambah menu (hanya admin).
     */
    public function create()
    {
        return view('menus.create');
    }

    /**
     * Simpan menu baru (hanya admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'available' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'available']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit menu (hanya admin).
     */
    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    /**
     * Update menu (hanya admin).
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'available' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'available']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diupdate!');
    }

    /**
     * Hapus menu (hanya admin).
     */
    public function destroy(Menu $menu)
    {
        // Hapus gambar lama jika ada
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus!');
    }
}
