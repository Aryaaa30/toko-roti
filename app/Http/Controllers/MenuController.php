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
        $query = Menu::where('kategori', '!=', 'birthday')->with('reviews');
        if ($category) {
            $query->where('kategori', $category);
        }
        $menus = $query->paginate(9);

        // Query untuk top products (tidak mengganggu pagination utama)
        $topProducts = Menu::where('kategori', '!=', 'birthday')
            ->with('reviews')
            ->get()
            ->sortByDesc(function($menu) {
                return $menu->reviews->avg('rating') ?? 0;
            })->take(4);

        // Query untuk category counts
        $categories = ['Roti Manis', 'Roti Tawar', 'Kue (Cake)', 'Donat', 'Pastry'];
        $categoryCounts = [];
        foreach($categories as $cat) {
            $categoryCounts[$cat] = Menu::where('kategori', $cat)->where('kategori', '!=', 'birthday')->count();
        }

        return view('menus.menu_user', [
            'menus' => $menus,
            'topProducts' => $topProducts,
            'categoryCounts' => $categoryCounts,
            'categories' => $categories,
            'category' => $category
        ]);
    }

    public function bakeries(Request $request)
    {
        $category = $request->query('kategori');
        $query = Menu::where('kategori', '!=', 'birthday')->with('reviews');
        if ($category) {
            $query->where('kategori', $category);
        }
        $menus = $query->paginate(9);

        $topProducts = Menu::where('kategori', '!=', 'birthday')
            ->with('reviews')
            ->get()
            ->sortByDesc(function($menu) {
                return $menu->reviews->avg('rating') ?? 0;
            })->take(4);

        $categories = ['Roti Manis', 'Roti Tawar', 'Kue (Cake)', 'Donat', 'Pastry'];
        $categoryCounts = [];
        foreach($categories as $cat) {
            $categoryCounts[$cat] = Menu::where('kategori', $cat)->where('kategori', '!=', 'birthday')->count();
        }

        return view('menus.menu_user', [
            'menus' => $menus,
            'topProducts' => $topProducts,
            'categoryCounts' => $categoryCounts,
            'categories' => $categories,
            'category' => $category
        ]);
    }

    public function show(Menu $menu)
    {
        // Load reviews dengan relasi user untuk ditampilkan di detail
        $menu->load(['reviews' => function($query) {
            $query->with('user')->orderBy('created_at', 'desc');
        }]);
        
        // Ambil data alamat user jika sudah login
        $addresses = collect();
        $defaultAddress = null;
        $user = auth()->user();
        
        if ($user) {
            $addresses = $user->addresses ?? collect();
            $defaultAddress = $addresses->where('is_default', true)->first() ?? $addresses->first();
        }
        
        return view('menus.detail', [
            'menu' => $menu,
            'isLoggedIn' => auth()->check(),
            'user' => $user,
            'addresses' => $addresses,
            'defaultAddress' => $defaultAddress
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
            'kategori' => 'required|in:Roti Manis,Roti Tawar,Kue (Cake),Donat,Pastry,birthday',
            'images.*' => 'nullable|image|max:2048',
            'flavor' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['name', 'description', 'price', 'available', 'stok', 'kategori', 'flavor']);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (!$image->isValid()) {
                    return back()->withErrors(['images' => 'Gagal upload gambar, file tidak valid.']);
                }
                $filename = uniqid('menu_') . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('menus', $filename, 'public');
                if (!$path) {
                    return back()->withErrors(['images' => 'Gagal menyimpan gambar ke storage.']);
                }
                $imagePaths[] = $path;
            }
        } else {
            // Debug jika tidak ada file yang terdeteksi
            return back()->withErrors(['images' => 'Tidak ada file gambar yang diupload!']);
        }
        $data['images'] = json_encode($imagePaths);

        $menu = Menu::create($data);

        // If it's a birthday cake, redirect to the birthday admin page
        if ($request->kategori === 'birthday') {
            return redirect()->route('birthday.admin')->with('success', 'Kue ulang tahun berhasil ditambahkan!');
        }

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
            'kategori' => 'required|in:Roti Manis,Roti Tawar,Kue (Cake),Donat,Pastry,birthday',
            'images.*' => 'nullable|image|max:2048',
            'flavor' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['name', 'description', 'price', 'available', 'stok', 'kategori', 'flavor']);

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

        // If it's a birthday cake, redirect to the birthday admin page
        if ($menu->kategori === 'birthday') {
            return redirect()->route('birthday.admin')->with('success', 'Kue ulang tahun berhasil diupdate!');
        }

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

        $isBirthday = $menu->kategori === 'birthday';
        
        $menu->delete();

        if ($isBirthday) {
            return redirect()->route('birthday.admin')->with('success', 'Kue ulang tahun berhasil dihapus!');
        }

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function categories(Request $request)
    {
        // Tangkap kategori yang dikirim di URL
        $kategori = $request->type;

        // If birthday is requested, redirect to birthday page
        if ($kategori === 'birthday') {
            return redirect()->route('birthday');
        }

        // Query hanya menu dengan kategori tersebut
        $menus = Menu::where('kategori', $kategori)->with('reviews')->get();

        // Kirim data ke view
        return view('menus.categories', compact('menus', 'kategori'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $menus = Menu::where(function($q) use ($query) {
                        $q->where('name', 'LIKE', "%{$query}%")
                          ->orWhere('kategori', 'LIKE', "%{$query}%");
                    })
                    ->where('kategori', '!=', 'birthday')
                    ->get();

        return view('your-view-name', compact('menus'));
    }
}
