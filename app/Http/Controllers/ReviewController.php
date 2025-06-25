<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar review (bisa untuk admin atau user).
     */
    public function index(Request $request)
    {
        // Ambil menu_id dari request untuk menentukan produk yang akan direview
        $menu_id = $request->get('menu_id');
        $menu = null;
        
        // Selalu gunakan menu_id dari request jika tersedia
        if ($menu_id) {
            $menu = Menu::find($menu_id);
            
            // Jika menu_id tidak valid, tampilkan pesan error
            if (!$menu) {
                return redirect()->route('menus.index')->with('error', 'Menu tidak ditemukan.');
            }
        } else if (!auth()->user()->is_admin) {
            // Jika tidak ada menu_id, redirect ke halaman menu
            return redirect()->route('menus.index')->with('info', 'Silakan pilih menu yang ingin direview.');
        }
        
        // Jika masih tidak ada menu dan user adalah admin, ambil menu pertama
        if (!$menu && auth()->user()->is_admin) {
            $menu = Menu::first();
            
            // Jika masih tidak ada menu, buat object kosong untuk menghindari error
            if (!$menu) {
                $menu = (object) ['id' => 1, 'name' => 'Menu tidak tersedia'];
            }
        }

        // Ambil semua review untuk menu yang dipilih
        $menuReviews = Review::where('menu_id', $menu->id ?? 1)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik review
        $totalReviews = $menuReviews->count();
        $averageRating = $totalReviews > 0 ? $menuReviews->avg('rating') : 0;
        
        // Hitung breakdown rating (1-5 bintang)
        $ratingCounts = [
            1 => $menuReviews->where('rating', 1)->count(),
            2 => $menuReviews->where('rating', 2)->count(),
            3 => $menuReviews->where('rating', 3)->count(),
            4 => $menuReviews->where('rating', 4)->count(),
            5 => $menuReviews->where('rating', 5)->count(),
        ];

        // Jika admin, tampilkan semua review untuk menu yang dipilih, jika user hanya review untuk menu yang dipilih
        if (auth()->user()->is_admin) {
            // Admin melihat semua review untuk menu yang dipilih
            $reviews = Review::where('menu_id', $menu->id ?? 1)
                ->with(['user', 'menu'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // User biasa melihat semua review untuk menu yang dipilih
            $reviews = Review::where('menu_id', $menu->id ?? 1)
                ->with(['user', 'menu'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('reviews.review', compact('reviews', 'menu', 'menuReviews', 'totalReviews', 'averageRating', 'ratingCounts'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form tambah review untuk menu tertentu.
     */
    public function create(Request $request)
    {
        // Pastikan menu_id selalu ada
        if (!$request->has('menu_id') && !$request->has('order_id')) {
            return redirect()->route('menus.index')->with('error', 'Silakan pilih menu yang ingin direview.');
        }
        
        if ($request->has('order_id')) {
            $order = Order::with('items.menu')->findOrFail($request->order_id);
            
            if ($order->user_id !== auth()->id()) {
                abort(403, 'Akses ditolak.');
            }
            
            if ($order->payment_status !== 'success') {
                return redirect()->back()->with('error', 'Anda hanya bisa memberi review jika produk sudah dikonfirmasi dan pembayaran berhasil.');
            }
            
            return view('reviews.create_from_order', compact('order'));
        }
        
        $menuId = $request->menu_id;
        
        // Pastikan menu_id valid
        if (!$menuId) {
            return redirect()->route('menus.index')->with('error', 'Silakan pilih menu yang ingin direview.');
        }
        
        $menu = Menu::findOrFail($menuId);
        
        $hasConfirmedOrder = Order::where('user_id', auth()->id())
            ->where('payment_status', 'success')
            ->whereHas('items', function ($query) use ($menuId) {
                $query->where('menu_id', $menuId);
            })->exists();

        if (!$hasConfirmedOrder) {
            return redirect()->back()->with('error', 'Anda hanya bisa memberi review jika produk sudah dikonfirmasi dan pembayaran berhasil.');
        }

        // Ambil review yang sudah ada untuk menu ini (jika ada)
        $existingReview = Review::where('user_id', auth()->id())
            ->where('menu_id', $menuId)
            ->first();
            
        return view('reviews.create', compact('menu', 'existingReview'));
    }

    /**
     * Store a newly created resource in storage.
     * Simpan review baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cek apakah user sudah beli menu ini dan pembayaran berhasil
        // Dapatkan order yang valid untuk review (payment_status success)
        $validOrder = Order::where('user_id', auth()->id())
            ->where('payment_status', 'success')
            ->whereHas('items', function ($query) use ($request) {
                $query->where('menu_id', $request->menu_id);
            })
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$validOrder) {
            return redirect()->back()->with('error', 'Anda hanya bisa memberi review jika produk sudah dikonfirmasi dan pembayaran berhasil.');
        }
        
        // Simpan order_id untuk digunakan nanti
        $validOrderId = $validOrder->id;
        
        // Handle image uploads
        $imagesPaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review-images', 'public');
                $imagesPaths[] = $path;
            }
        }

        // Cek apakah user sudah pernah review menu ini sebelumnya
        $existingReview = Review::where('user_id', auth()->id())
            ->where('menu_id', $request->menu_id)
            ->first();

        if ($existingReview) {
            // Update review yang sudah ada
            $updateData = [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'order_id' => $request->order_id ?? $existingReview->order_id,
            ];
            
            // Jika ada gambar baru, tambahkan ke gambar yang sudah ada
            if (!empty($imagesPaths)) {
                $existingImages = $existingReview->images ?? [];
                $updateData['images'] = array_merge($existingImages, $imagesPaths);
            }
            
            $existingReview->update($updateData);
            
            $review = $existingReview;
            $message = 'Review berhasil diperbarui! Terima kasih atas ulasan Anda.';
        } else {
            // Simpan review baru
            $review = Review::create([
                'user_id' => auth()->id(),
                'menu_id' => $request->menu_id,
                'order_id' => $request->order_id ?? $validOrderId, // Gunakan order_id yang valid
                'rating' => $request->rating,
                'comment' => $request->comment,
                'images' => !empty($imagesPaths) ? $imagesPaths : null,
            ]);
            
            $message = 'Review berhasil ditambahkan! Terima kasih atas ulasan Anda.';
        }

        // Perbarui cache rating pada menu jika diperlukan
        // (Laravel akan otomatis menggunakan method getAverageRatingAttribute di model Menu)

        // Redirect kembali ke halaman review dengan pesan sukses
        if ($request->has('redirect_to_review') && $request->redirect_to_review) {
            return redirect()->route('customer.reviews', ['menu_id' => $request->menu_id])->with('success', $message);
        }
        
        // Jika tidak ada flag redirect_to_review, gunakan behavior default
        return redirect()->route('menus.show', $request->menu_id)->with('success', $message);
    }

    /**
     * Display the specified resource.
     * Menampilkan detail review.
     */
    public function show(Review $review)
    {
        // Cek akses user/admin
        if (!auth()->user()->is_admin && $review->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $review->load('menu', 'user');

        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form edit review.
     */
    public function edit(Review $review)
    {
        if (!auth()->user()->is_admin && $review->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $review->load('menu');

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     * Update review.
     */
    public function update(Request $request, Review $review)
    {
        if (!auth()->user()->is_admin && $review->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     * Hapus review.
     */
    public function destroy(Review $review)
    {
        if (!auth()->user()->is_admin && $review->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Review berhasil dihapus.');
    }
}
