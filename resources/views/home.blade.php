@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    body {
        background-color: #ffffff;
        font-family: 'Segoe UI', sans-serif;
    }

    .header-area {
        text-align: center;
        padding: 40px 20px 20px;
    }

    .header-area h1 {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
    }

    .product-grid {
        display: flex;
        overflow-x: auto;
        gap: 16px;
        padding: 20px 30px;
        scroll-snap-type: x mandatory;
    }

    .card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        width: 180px;
        scroll-snap-align: start;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        font-size: 13px;
    }

    .card img {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .card:hover img {
        transform: scale(1.03);
    }

    .card-body {
        padding: 10px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-title {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
        color: #2c3e50;
        line-height: 1.2em;
        height: 2.4em;
        overflow: hidden;
    }

    .card-price {
        color: #e74c3c;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .card-meta {
        display: flex;
        justify-content: space-between;
        color: #7f8c8d;
        font-size: 12px;
        margin-top: 4px;
    }

    .star {
        color: #f39c12;
    }

    .alert {
        max-width: 700px;
        margin: 20px auto;
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
    }

    .product-grid::-webkit-scrollbar {
        height: 8px;
    }

    .product-grid::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.2);
        border-radius: 8px;
    }
</style>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

<div class="product-grid">
    @foreach($menus as $menu)
        <div class="card">
            <a href="{{ route('menus.show', $menu->id) }}">
                @if($menu->image)
                    <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}">
                @else
                    <img src="https://via.placeholder.com/180?text=No+Image" alt="No image">
                @endif
            </a>
            <div class="card-body">
                <div class="card-title">{{ $menu->name }}</div>
                <div class="card-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                @php
                    $avgRating = round($menu->reviews->avg('rating'), 1);
                @endphp

                <div class="card-meta">
                    <span><span class="star">★</span> {{ $avgRating ?: '0.0' }}</span>
                    <span>{{ $menu->stok }}+ terjual</span>
                </div>

                <div class="card-meta">
                    <span>{{ $menu->kategori ?? 'Kategori' }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>

<footer class="bg-gray-100 text-gray-800 border-t mt-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-2 md:grid-cols-4 gap-8 text-sm">
    <div>
      <h3 class="font-semibold mb-4">Toko Roti</h3>
      <ul class="space-y-2">
        <li><a href="#" class="hover:underline">Tentang Kami</a></li>
        <li><a href="#" class="hover:underline">Karir</a></li>
        <li><a href="#" class="hover:underline">Blog</a></li>
        <li><a href="#" class="hover:underline">Promo Hari Ini</a></li>
      </ul>
    </div>
  </div>
  <div class="border-t py-4 bg-gray-200 text-center text-sm flex flex-col md:flex-row justify-between items-center px-4 md:px-8">
    <div>© 2009 - 2025, PT. Toko Roti. All Rights Reserved.</div>
    <div class="flex space-x-4 mt-2 md:mt-0">
      <button class="px-3 py-1 rounded-md border border-gray-400 text-sm">Indonesia</button>
      <button class="px-3 py-1 rounded-md border border-gray-400 text-sm">English</button>
    </div>
  </div>
</footer>

@endsection
