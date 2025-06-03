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
    public function index()
    {
        // Jika admin, tampilkan semua review, jika user hanya review miliknya
        if (auth()->user()->is_admin) {
            $reviews = Review::with(['user', 'menu'])->orderBy('created_at', 'desc')->get();
        } else {
            $reviews = Review::where('user_id', auth()->id())->with('menu')->orderBy('created_at', 'desc')->get();
        }

        return view('reviews.review', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form tambah review untuk menu tertentu.
     */
    public function create(Request $request)
    {
        $menuId = $request->menu_id;

        // Pastikan menu ada
        $menu = Menu::findOrFail($menuId);

        // Cek apakah user sudah beli menu ini (bisa cek dari order)
        $hasOrdered = Order::where('user_id', auth()->id())
            ->whereHas('items', function ($query) use ($menuId) {
                $query->where('menu_id', $menuId);
            })->exists();

        if (!$hasOrdered) {
            return redirect()->back()->with('error', 'Anda hanya bisa memberi review jika sudah membeli produk ini.');
        }

        return view('reviews.create', compact('menu'));
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
        ]);

        // Cek apakah user sudah beli menu ini (sama seperti di create)
        $hasOrdered = Order::where('user_id', auth()->id())
            ->whereHas('items', function ($query) use ($request) {
                $query->where('menu_id', $request->menu_id);
            })->exists();

        if (!$hasOrdered) {
            return redirect()->back()->with('error', 'Anda hanya bisa memberi review jika sudah membeli produk ini.');
        }

        // Simpan review
        Review::create([
            'user_id' => auth()->id(),
            'menu_id' => $request->menu_id,
            'order_id' => null, // bisa diisi jika ingin kaitkan dengan order tertentu
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review berhasil ditambahkan.');
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
