<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Unauthenticated',
                    'message' => 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang',
                    'redirect' => route('login')
                ], 401);
            }
            
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang');
        }

        return $next($request);
    }
}