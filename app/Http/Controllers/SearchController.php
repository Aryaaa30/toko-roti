<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query');
        
        // Pastikan query tidak kosong untuk pencarian
        if (!empty($query)) {
            $menus = Menu::where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('kategori', 'like', '%' . $query . '%');
            })
            ->where('available', 1) // Hanya tampilkan produk yang tersedia
            ->with('reviews') // Load reviews untuk ratings
            ->take(10)
            ->get();
        } else {
            $menus = collect([]);
        }

        // Dapatkan best sellers berdasarkan jumlah penjualan dari OrderItem
        $bestSellers = Menu::select('menus.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->leftJoin('order_items', 'menus.id', '=', 'order_items.menu_id')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed') // Hanya hitung dari pesanan yang sudah selesai
            ->where('menus.available', 1) // Hanya tampilkan produk yang tersedia
            ->groupBy('menus.id')
            ->orderBy('total_sold', 'desc')
            ->with('reviews')
            ->take(5)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.search-results', compact('menus', 'bestSellers', 'query'))->render()
            ]);
        }
        
        return view('search', compact('menus', 'bestSellers', 'query'));
    }
    
    /**
     * Search API endpoint untuk digunakan oleh Alpine.js
     */
    public function searchApi(Request $request)
    {
        $query = $request->get('query');
        
        if (empty($query)) {
            return response()->json([
                'results' => []
            ]);
        }
        
        $menus = Menu::where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('kategori', 'like', '%' . $query . '%');
            })
            ->where('available', 1) // Hanya tampilkan produk yang tersedia
            ->with('reviews')
            ->take(8)
            ->get()
            ->map(function($menu) {
                // Format hasil untuk ditampilkan di search panel
                $image = null;
                
                if ($menu->images) {
                    $images = json_decode($menu->images);
                    if (is_array($images) && count($images) > 0) {
                        $image = asset('storage/' . $images[0]);
                    }
                } elseif ($menu->image) {
                    $image = asset('storage/' . $menu->image);
                }
                
                return [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'price' => $menu->price,
                    'formatted_price' => 'Rp ' . number_format($menu->price, 0, ',', '.'),
                    'category' => $menu->kategori,
                    'image' => $image,
                    'url' => route('menus.show', $menu->id)
                ];
            });
            
        return response()->json([
            'results' => $menus
        ]);
    }
}