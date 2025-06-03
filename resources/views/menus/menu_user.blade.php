@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #F5F5F5; /* Background color to match design */
  }

  /* Submenu (category selector) */
  .submenu-container {
    background: #FFFFFF;
    border-bottom: 2px solid #E0E0E0;
    padding: 10px 0;
    display: flex;
    justify-content: center;
    overflow-x: auto;
    white-space: nowrap;
  }

  .submenu {
    padding: 10px 20px;
    margin: 0 5px;
    border-radius: 20px;
    background: #F0F0F0; /* Light gray background for submenu */
    transition: background 0.3s;
    font-size: 14px;
    text-transform: uppercase;
    font-weight: bold;
    color: #333;
    cursor: pointer; /* Change cursor to pointer */
  }

  .submenu.active,
  .submenu:hover {
    background: #2c3e50;
    color: #fff;
  }

  /* Product grid */
  .category-container {
    display: flex;
    margin-top: 20px; /* Space above grid */
  }

  .category-name {
    flex-basis: 25%; /* Spacing for category name */
    font-weight: bold;
    font-size: 24px; /* Increased font size */
    padding-right: 20px; /* Spacing between category and products */
    text-align: center; /* Center the category name */
  }

  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    flex-grow: 1;
  }

  .card {
    background: #fff;
    border-radius: 15px; /* Rounded corners */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Softer shadow */
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    transition: transform 0.3s;
  }

  .card:hover {
    transform: translateY(-5px); /* Slight lift on hover */
  }

  .card img {
    width: 100%; /* Full width */
    aspect-ratio: 1 / 1; /* Aspect ratio for images */
    object-fit: cover;
  }

  .card-body {
    padding: 15px;
    display: flex;
    flex-direction: column;
  }

  .card-title {
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 4px;
    color: #333;
  }

  .card-price {
    color: #e74c3c;
    font-weight: bold;
    margin-bottom: 4px;
    font-size: 14px;
  }

  .card-meta {
    display: flex;
    justify-content: space-between;
    color: #7f8c8d;
    font-size: 12px;
    align-items: center;
  }

  .star {
    color: #f39c12;
  }

  /* Footer styling */
  footer {
    background-color: #f9f9f9;
  }

  footer .footer-links h3 {
    font-weight: bold;
    margin-bottom: 10px;
  }

  .text-container {
    text-align: center;  /* Center the text */
    margin-left: 20px;   /* Space on the left */
    margin-right: 20px;  /* Space on the right */
  }

  .text-container p {
    font-size: 2em;     /* Increased font size */
  }

</style>

<!-- Submenu (category selector) -->
<div class="submenu-container">
  @php
    $categories = ['Roti Manis', 'Roti Tawar', 'Kue (Cake)', 'Donat', 'Pastry'];
  @endphp
  @foreach($categories as $cat)
    @php
      $slug = Str::slug($cat, '-');
      $active = ($category === $slug) ? 'active' : '';
    @endphp
    <span class="submenu {{ $active }}" onclick="scrollToCategory('{{ $slug }}')">{{ $cat }}</span>
  @endforeach
</div>

<!-- Category and Product Grid -->
@foreach($categories as $cat)
  <div class="category-container" id="{{ Str::slug($cat, '-') }}">
    <div class="category-name">{{ $cat }}</div>
    <div class="product-grid">
      @foreach($menus->where('kategori', $cat) as $menu)
        <a href="{{ route('menus.show', $menu->id) }}" class="card">
          @if($menu->image)
            <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}">
          @else
            <img src="https://via.placeholder.com/250?text=No+Image" alt="No image">
          @endif
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
        </a>
      @endforeach
    </div>
  </div>
@endforeach

<footer class="bg-gray-100 text-gray-800 border-t mt-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-2 md:grid-cols-4 gap-8 text-sm footer-links">
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

<script>
  function scrollToCategory(category) {
    // Scroll to the selected category
    const selectedCategory = document.getElementById(category);
    if (selectedCategory) {
      selectedCategory.scrollIntoView({ behavior: 'smooth' });
    }
  }
</script>

@endsection