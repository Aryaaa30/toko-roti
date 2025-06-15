<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
        // Tidak perlu middleware auth untuk index dan show
    }

   public function index(Request $request)
    {
        $category = $request->query('kategori');

        if ($category) {
            $menus = Menu::where('kategori', $category)->get();
        } else {
            $menus = Menu::with('reviews')->get();
        }

        if (auth()->check() && auth()->user()->is_admin) {
            return view('menus.menu_admin', compact('menus'));
        } else {
            // Perbaiki bagian ini: selalu kirim $category ke view
            return view('menus.menu_user', [
                'menus' => $menus,
                'category' => $category // walaupun null, dikirim tetap
            ]);
        }
    }

    public function bakeries(Request $request)
    {
        $category = $request->query('kategori');

        if ($category) {
            $menus = Menu::where('kategori', $category)->get();
        } else {
            $menus = Menu::with('reviews')->get();
        }

        if (auth()->check() && auth()->user()->is_admin) {
            return view('menus.menu_admin', compact('menus'));
        } else {
            return view('menus.menu_user', [
                'menus' => $menus,
                'category' => $category
            ]);
        }
    }

    public function show(Menu $menu)
    {
        return view('menus.detail', [
            'menu' => $menu,
            'isLoggedIn' => auth()->check()
        ]);
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'available' => 'required|boolean',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|in:Roti Manis,Roti Tawar,Kue (Cake),Donat,Pastry',
            'images.*' => 'nullable|image|max:2048', // validasi setiap gambar
        ]);

        $data = $request->only(['name', 'description', 'price', 'available', 'stok', 'kategori']);

        // Upload dan simpan banyak gambar
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Berikan nama unik yang lebih pendek
                $filename = uniqid('menu_') . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('menus', $filename, 'public');
                $imagePaths[] = $path;
            }
        }

        $data['images'] = json_encode($imagePaths); // simpan sebagai JSON

        Menu::create($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'available' => 'required|boolean',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|in:Roti Manis,Roti Tawar,Kue (Cake),Donat,Pastry',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'available', 'stok', 'kategori']);

        // Upload gambar baru dan hapus lama
        if ($request->hasFile('images')) {
            // Hapus gambar lama
            if ($menu->images) {
                foreach (json_decode($menu->images) as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }

            $newImagePaths = [];
            foreach ($request->file('images') as $image) {
                // Berikan nama unik yang lebih pendek
                $filename = uniqid('menu_') . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('menus', $filename, 'public');
                $newImagePaths[] = $path;
            }

            $data['images'] = json_encode($newImagePaths);
        }

        $menu->update($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->images) {
            foreach (json_decode($menu->images) as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function categories(Request $request)
    {
        // Tangkap kategori yang dikirim di URL
        $kategori = $request->type;

        // Query hanya menu dengan kategori tersebut
        $menus = Menu::where('kategori', $kategori)->with('reviews')->get();

        // Kirim data ke view
        return view('menus.categories', compact('menus', 'kategori'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $menus = Menu::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('kategori', 'LIKE', "%{$query}%")
                    ->get();

        return view('your-view-name', compact('menus'));
    }
}
