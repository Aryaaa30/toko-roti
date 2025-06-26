<?php

namespace App\Providers;
  
  use Illuminate\Support\ServiceProvider;
  use App\Models\Address;
  
  class AppServiceProvider extends ServiceProvider
  {
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Berbagi variabel cartCount dan bestSellers ke semua view
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                  $view->with('cartCount', $cartCount);
  
                  $addresses = Address::where('user_id', auth()->id())->get();
                  $defaultAddress = $addresses->where('is_default', true)->first();
                  $view->with('addresses', $addresses);
                  $view->with('defaultAddress', $defaultAddress);
              }
  
              // Tambahkan best sellers ke semua view untuk navigasi search
            $bestSellers = \App\Models\Menu::select('menus.*', \DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
                ->leftJoin('order_items', 'menus.id', '=', 'order_items.menu_id')
                ->leftJoin('orders', function($join) {
                    $join->on('orders.id', '=', 'order_items.order_id')
                         ->where('orders.status', 'completed');
                })
                ->where('menus.available', 1)
                ->groupBy('menus.id')
                ->orderBy('total_sold', 'desc')
                ->with('reviews')
                ->take(5)
                ->get();

            $view->with('bestSellers', $bestSellers);
        });
    }
}
