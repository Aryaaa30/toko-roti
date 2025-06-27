<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin confirmation page
     */
    public function konfirmasi()
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        // Get all orders with user and items
        $orders = Order::with(['user', 'items.menu'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $stats = [
            'pending' => $orders->where('payment_status', 'pending')->count(),
            'success' => $orders->where('payment_status', 'success')->count(),
            'failed' => $orders->where('payment_status', 'failed')->count(),
            'cancelled' => $orders->where('payment_status', 'cancelled')->count(),
        ];

        return view('admin.konfirmasi_admin', compact('orders', 'stats'));
    }

    /**
     * Display admin review page
     */
    public function reviewAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        // Ambil semua review dengan relasi user dan menu
        $reviews = Review::with(['user', 'menu'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Tidak perlu mengambil recent feedback karena sudah dihapus dari tampilan

        // Hitung statistik review
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;
        
        // Hitung breakdown rating (1-5 bintang)
        $ratingCounts = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        // Hitung persentase untuk setiap rating
        $ratingPercentages = [];
        foreach ($ratingCounts as $rating => $count) {
            $ratingPercentages[$rating] = $totalReviews > 0 ? round(($count / $totalReviews) * 100, 1) : 0;
        }

        // Ambil statistik rating per produk
        $menuRatings = [];
        $menus = \App\Models\Menu::has('reviews')->get();
        foreach ($menus as $menu) {
            $menuRatings[] = [
                'menu' => $menu,
                'average_rating' => $menu->getAverageRatingAttribute(),
                'review_count' => $menu->getReviewCountAttribute()
            ];
        }
        
        // Urutkan berdasarkan rating tertinggi
        usort($menuRatings, function($a, $b) {
            return $b['average_rating'] <=> $a['average_rating'];
        });

        return view('admin.review_admin', compact(
            'reviews', 
            'totalReviews', 
            'averageRating', 
            'ratingCounts', 
            'ratingPercentages', 
            'menuRatings'
        ));
    }

    /**
     * Display admin menu management page
     */
    public function menuAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }

        // Get all menus with reviews
        $menus = \App\Models\Menu::with('reviews')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $stats = [
            'total' => $menus->count(),
            'available' => $menus->where('available', 1)->count(),
            'unavailable' => $menus->where('available', 0)->count(),
        ];

        return view('admin.menu_admin', compact('menus', 'stats'));
    }
}