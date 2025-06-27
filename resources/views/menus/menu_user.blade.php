@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
  /* Gold color for Bake My Day theme */
  :root {
    --bmd-pink: rgb(254, 198, 228);
  }

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color:rgb(0, 0, 0);
    margin: 0;
    padding: 0;
  }

  /* Hero Section */
  .hero-section {
    background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2072&q=80');
    background-size: cover;
    background-position: center;
    height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
    margin-bottom: 50px;
  }

  .hero-content h1 {
    font-size: 3.5rem;
    font-weight: 300;
    margin-bottom: 10px;
    letter-spacing: 2px;
  }

  .hero-content p {
    font-size: 1.1rem;
    margin-bottom: 30px;
    opacity: 0.9;
  }

  .breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
    margin:20px;
  }

  .breadcrumb-nav a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
  }

  .breadcrumb-nav a:hover {
    color: white;
  }

  /* Main Content Container */
  .main-container {
    max-width: 1250px;
    margin: 0 auto;
    padding: 0 20px;
  }

  /* Top Controls */
  .top-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
  }

  .search-container {
    flex: 2;
  }

  .search-input {
    width: 100%;
    padding: 12px 20px;
    border: 1px solid #222 !important;
    border-radius: 25px;
    font-size: 14px;
    outline: none;
    background: #111 !important;
    color: var(--bmd-pink) !important;
  }

  .search-input::placeholder {
    color: var(--bmd-pink) !important;
  }

  .results-info {
    color: #666;
    font-size: 14px;
  }

  .sort-container {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .sort-container label {
    color: var(--bmd-pink) !important;
    font-weight: 600;
  }

  .sort-select {
    padding: 8px 15px;
    border: 1px solid #222;
    border-radius: 5px;
    background: #111 !important;
    color: var(--bmd-pink) !important;
    border: 1px solid var(--bmd-pink) !important;
  }

  .view-toggle {
    display: flex;
    border: 1px solid #222;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    background: #111 !important;
    border: 1px solid var(--bmd-pink) !important;
  }

  .view-btn {
    padding: 8px 12px;
    background: #111 !important;
    border: none;
    cursor: pointer;
    color: var(--bmd-pink) !important;
    transition: all 0.3s ease;
    width: 40px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .view-btn:hover {
    background: #f8f8f8;
  }

  .view-btn.active {
    background: var(--bmd-pink) !important;
    color: #111 !important;
  }

  .view-btn i {
    color: var(--bmd-pink) !important;
  }

  .view-btn.active i {
    color: #111 !important;
  }

  /* Sidebar and Content Layout */
  .content-layout {
    display: flex;
    gap: 30px;
  }

  .sidebar {
    width: 250px;
    flex-shrink: 0;
  }

  .main-content {
    flex: 1;
  }

  /* Sidebar Sections */
  .sidebar-section {
    background: #111 !important;
    color: #fff !important;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
  }

  .sidebar-section h3 {
    color: var(--bmd-pink) !important;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
  }

  .category-list {
    list-style: none;
    padding: 0;
    margin: 0;

  }

  .category-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #222;
    cursor: pointer;
    transition: color 0.3s;  
  }

  .category-item,
  .category-item span {
    color: var(--bmd-pink) !important;
  }

  .category-item.active,
  .category-item:hover {
    color: var(--bmd-pink) !important;
    font-weight: 700;
  }

  .category-count {
    background: #222 !important;
    color: #fff !important;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
    color: #666;
  }

  /* Price Filter */
  .price-filter {
    margin: 15px 0;
  }

  .price-dropdown {
    width: 100%;
    padding: 10px 35px 10px 15px;
    border: 1px solid var(--bmd-pink) !important;
    border-radius: 5px;
    background: #222 !important;
    color: #fff !important;
    font-size: 14px;
    outline: none;
    transition: all 0.3s ease;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23fec6e4" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 12px;
  }

  .price-dropdown:focus {
    border-color: var(--bmd-pink) !important;
    box-shadow: 0 0 0 2px rgba(254, 198, 228, 0.2);
  }

  .price-dropdown option {
    background: #222 !important;
    color: #fff !important;
    padding: 8px;
  }

  /* Top Products */
  .top-product-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #222;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  
  .top-product-item:hover {
    background-color: rgba(254, 198, 228, 0.1);
    transform: translateX(5px);
    text-decoration: none;
    color: inherit;
  }

  .top-product-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
    background: #222 !important;
  }

  .top-product-info h4 {
    font-size: 14px;
    margin: 0 0 5px 0;
    color: var(--bmd-pink) !important;
  }

  .top-product-price {
    font-size: 12px;
    color: #fff !important;
    font-weight: 600;
  }

  /* Tags */
  .tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }

  .tag {
    background: #222 !important;
    color: #fff !important;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s;
    margin-bottom: 8px;
    display: inline-block;
  }

  .tag:hover,
  .tag.active {
    background: var(--bmd-pink) !important;
    color: #111 !important;
    font-weight: bold;
  }

  /* Product Grid */
  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 50px;
    transition: all 0.5s ease;
  }
  
  .view-transition {
    opacity: 0.8;
    transform: scale(0.98);
  }
  
  .view-transition-end {
    opacity: 1;
    transform: scale(1);
  }

  .product-card {
    background: #111 !important;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
    position: relative;
  }

  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    text-decoration: none;
    color: inherit;
  }
  
  /* List View Specific Styles */
  .product-card.list-view {
    display: flex;
    align-items: stretch;
    transform: none;
    border-left: 4px solid var(--bmd-pink) !important;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    position: relative;
    overflow: visible;
    animation: fadeInUp 0.5s ease-out;
    background: #111;
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .product-card.list-view:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    background-color: #fffaf5;
    cursor: pointer;
  }
  
  .product-card.list-view:hover .view-details-msg {
    color: #d4a574;
    font-weight: 500;
  }
  
  .product-card.list-view::before {
    content: '';
    position: absolute;
    top: 0;
    left: -4px;
    height: 30%;
    width: 4px;
    background: linear-gradient(to bottom, #f1c40f, #d4a574);
    border-radius: 2px 0 0 0;
    transition: height 0.3s ease;
  }
  
  .product-card.list-view:hover::before {
    height: 100%;
  }
  
  .product-card.list-view .product-title {
    font-size: 20px;
    margin-bottom: 5px;
    color: var(--bmd-pink);
    position: relative;
    display: inline-block;
  }
  
  .product-card.list-view .product-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 40px;
    height: 2px;
    background-color: var(--bmd-pink) !important;
    transition: width 0.3s ease;
  }
  
  .product-card.list-view:hover .product-title::after {
    width: 100%;
  }
  
  .product-card.list-view .product-price {
    font-size: 18px;
    color: #fff !important;
    margin: 5px 0;
    font-weight: 700;
  }
  
  .product-card.list-view .product-meta {
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px;
    border-top: 1px dashed #222;
  }
  
  .product-card.list-view .product-badge {
    top: 10px;
    left: 10px;
    right: auto;
  }
  
  .product-card.list-view .product-image-container::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, rgba(0,0,0,0.1), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  
  .product-card.list-view:hover .product-image-container::after {
    opacity: 1;
  }
  
  .product-card.list-view .quick-action-btn {
    transition: all 0.2s ease;
  }
  
  .product-card.list-view .quick-action-btn:hover {
    transform: translateY(-2px);
  }
  
  .product-card.list-view .add-to-cart:hover {
    background-color: #c39366;
  }
  
  .product-card.list-view .view-details:hover {
    background-color: #e9ecef;
  }
  
  .product-card.list-view .product-description {
    position: relative;
    padding-left: 10px;
    border-left: 2px solid #f1f1f1;
  }
  
  .product-card.list-view .rating-stars {
    font-size: 16px;
  }

  .product-image-container {
    position: relative;
    width: 100%;
    height: 250px;
    overflow: hidden;
  }

  .product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
  }

  .product-card:hover .product-image {
    transform: scale(1.05);
  }
  
  .carousel-container {
    position: relative;
    width: 100%;
    height: 100%;
  }
  
  .carousel-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.5s ease;
    z-index: 1;
  }
  
  .carousel-slide.active {
    opacity: 1;
    z-index: 2;
  }
  
  .carousel-nav {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 3;
    display: flex;
    justify-content: space-between;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s;
  }
  
  .product-image-container:hover .carousel-nav {
    opacity: 1;
  }
  
  .carousel-btn {
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    margin: 0 10px;
    font-size: 16px;
    transition: background 0.3s;
  }
  
  .carousel-btn:hover {
    background: rgba(0, 0, 0, 0.8);
  }
  
  .carousel-dots {
    position: absolute;
    bottom: 10px;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: center;
    gap: 5px;
    z-index: 3;
  }
  
  .carousel-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
  }
  
  .carousel-dot.active {
    background: white;
  }

  .product-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: var(--bmd-pink) !important;
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
  }

  .product-info {
    padding: 20px;
  }

  .product-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--bmd-pink) !important;
  }

  .product-price {
    font-size: 16px;
    font-weight: 700;
    color: #fff !important;
    margin-bottom: 10px;
  }

  .product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: #fff;
  }

  .product-rating {
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .rating-stars {
    color: rgb(254, 198, 228) !important;
  }

  .stock-info {
    font-size: 12px;
    color: #fff;
  }

  .stock-available {
    color: #28a745;
  }

  .stock-unavailable {
    color: #dc3545;
  }

  /* Pagination */
  .pagination-container {
    display: flex;
    justify-content: center;
    margin: 40px 0;
  }

  .pagination {
    display: flex;
    gap: 5px;
    align-items: center;
    background: #111 !important;
    border: 1px solid var(--bmd-pink) !important;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }

  .page-btn {
    width: 40px;
    height: 40px;
    border: none;
    background: #111 !important;
    color: var(--bmd-pink) !important;
    border-radius: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    font-weight: 600;
  }

  .page-btn:hover,
  .page-btn.active {
    background: var(--bmd-pink) !important;
    color: #111 !important;
    border: none;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .hero-content h1 {
      font-size: 2.5rem;
    }
    
    .content-layout {
      flex-direction: column;
    }
    
    .sidebar {
      width: 100%;
    }
    
    .top-controls {
      flex-direction: column;
      align-items: stretch;
    }
    
    .search-container {
      max-width: none;
    }
    
    .product-grid {
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }
  }

  @media (max-width: 480px) {
    .product-grid {
      grid-template-columns: 1fr;
    }
    
    .hero-content h1 {
      font-size: 2rem;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="hero-content">
    <h1>Product</h1>
    <p>Discover our fresh bakery products</p>
    
  </div>
</div>

<div class="main-container">
  <div class="breadcrumb-nav">
      <a href="/">Home</a>
      <span>></span>
      <span>Product</span>
    </div>
  <!-- Top Controls -->
  <div class="top-controls">
    
    <div class="search-container">
      <input type="text" class="search-input" placeholder="Search..." id="searchInput">
    </div>
    
    <div class="sort-container">
      <label for="sortSelect">Sort by:</label>
      <select class="sort-select" id="sortSelect">
        <option value="default">Default sorting</option>
        <option value="name">Name</option>
        <option value="price-low">Price: Low to High</option>
        <option value="price-high">Price: High to Low</option>
        <option value="rating">Rating</option>
      </select>
      
      <div class="view-toggle">
        <button class="view-btn active" data-view="grid" title="Grid View"><i class="fas fa-th"></i></button>
        <button class="view-btn" data-view="list" title="List View"><i class="fas fa-list"></i></button>
      </div>
    </div>
  </div>

  <div class="content-layout">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Categories -->
      <div class="sidebar-section">
        <h3>Categories</h3>
        <ul class="category-list">
          <li class="category-item active" data-category="all">
            <span>All Products</span>
            <span class="category-count">{{ $menus->total() }}</span>
          </li>
          @foreach($categories as $cat)
            @php
              $slug = Str::slug($cat, '-');
              $count = $categoryCounts[$cat] ?? 0;
            @endphp
            <li class="category-item" data-category="{{ $slug }}">
              <span>{{ $cat }}</span>
              <span class="category-count">{{ $count }}</span>
            </li>
          @endforeach
        </ul>
      </div>

      <!-- Price Filter -->
      <div class="sidebar-section">
        <h3><i class="fas fa-dollar-sign" style="color: rgb(254, 198, 228); margin-right: 8px;"></i>Filter by price</h3>
        <div class="price-filter" style="position: relative;">
          <select id="priceDropdown" class="price-dropdown">
            <option value="all">All Prices</option>
            <option value="1000-20000">Rp.1.000 - Rp.20.000</option>
            <option value="21000-40000">Rp.21.000 - Rp.40.000</option>
            <option value="41000-60000">Rp.41.000 - Rp.60.000</option>
            <option value="61000-80000">Rp.61.000 - Rp.80.000</option>
            <option value="81000-100000">Rp.81.000 - Rp.100.000</option>
            <option value="100001-999999">> Rp.100.000</option>
          </select>
          <i class="fas fa-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: rgb(254, 198, 228); pointer-events: none; font-size: 12px;"></i>
        </div>
      </div>

      <!-- Top Products -->
      <div class="sidebar-section">
        <h3>Top product</h3>
        @foreach($topProducts as $product)
          <a href="{{ route('menus.show', $product->id) }}" class="top-product-item" data-price="{{ $product->price }}">
            @php
              $image = null;
              if($product->images) {
                $images = json_decode($product->images, true);
                $image = is_array($images) && count($images) > 0 ? $images[0] : null;
              } elseif($product->image) {
                $image = $product->image;
              }
            @endphp
            @if($image)
              <img src="{{ asset('storage/'.$image) }}" alt="{{ $product->name }}" class="top-product-img">
            @else
              <div class="top-product-img" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">No Image</div>
            @endif
            <div class="top-product-info">
              <h4>{{ $product->name }}</h4>
              <div class="top-product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            </div>
          </a>
        @endforeach
      </div>

      <!-- Filter Rating -->
      <div class="sidebar-section">
        <h3>Filter Rating</h3>
        <div class="tags-container">
          <span class="tag active" data-rating="0">All Ratings</span>
          <span class="tag" data-rating="5">5 Stars ★★★★★</span>
          <span class="tag" data-rating="4">4+ Stars ★★★★☆</span>
          <span class="tag" data-rating="3">3+ Stars ★★★☆☆</span>
          <span class="tag" data-rating="2">2+ Stars ★★☆☆☆</span>
          <span class="tag" data-rating="1">1+ Star ★☆☆☆☆</span>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Product Grid -->
      <div class="product-grid" id="productGrid">
        @foreach($menus as $menu)
          @php
            $slug = Str::slug($menu->kategori, '-');
            $avgRating = round($menu->reviews->avg('rating'), 1);
            $image = null;
            if($menu->images) {
              $images = json_decode($menu->images, true);
              $image = is_array($images) && count($images) > 0 ? $images[0] : null;
            } elseif($menu->image) {
              $image = $menu->image;
            }
          @endphp
          
          <a href="{{ route('menus.show', $menu->id) }}" 
             class="product-card" 
             data-category="{{ $slug }}"
             data-price="{{ $menu->price }}"
             data-name="{{ strtolower($menu->name) }}"
             data-rating="{{ $avgRating }}"
             data-description="{{ $menu->description ?? 'Delicious bakery product from our collection. Perfect for any occasion.' }}">
            
            <div class="product-image-container">
              @if($menu->images)
                @php
                  $images = json_decode($menu->images, true);
                  $hasMultipleImages = is_array($images) && count($images) > 1;
                @endphp
                
                <div class="carousel-container" data-product-id="{{ $menu->id }}">
                  @foreach($images as $index => $img)
                    <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}">
                      <img src="{{ asset('storage/'.$img) }}" alt="{{ $menu->name }}" class="product-image">
                    </div>
                  @endforeach
                  
                  @if($hasMultipleImages)

                    
                    <div class="carousel-dots">
                      @foreach($images as $index => $img)
                        <div class="carousel-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                      @endforeach
                    </div>
                  @endif
                </div>
              @elseif($image)
                <img src="{{ asset('storage/'.$image) }}" alt="{{ $menu->name }}" class="product-image">
              @else
                <div class="product-image" style="background: linear-gradient(135deg, #f0f0f0, #e0e0e0); display: flex; align-items: center; justify-content: center; color: #999; font-size: 14px;">
                  No Image Available
                </div>
              @endif
              
              @if(!$menu->available)
                <div class="product-badge">Sold Out</div>
              @elseif($menu->stok < 5)
                <div class="product-badge">Low Stock</div>
              @endif
            </div>
            
            <div class="product-info">
              <h3 class="product-title">{{ $menu->name }}
                <span class="category-badge" style="display: inline-block; padding: 3px 8px; background-color: #f8f9fa; color: #666; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-left: 10px; vertical-align: middle;">{{ str_replace('-', ' ', $slug) }}</span>
              </h3>
              <div class="product-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
              <div class="product-meta">
                <div class="product-rating">
                  <span class="rating-stars">★</span>
                  <span>{{ $avgRating ?: '0.0' }}</span>
                  <span style="color: rgb(180, 180, 180); font-size: 0.8rem; margin-left: 4px;">
                    ({{ $menu->reviews->count() }})
                  </span>
                </div>
                <div class="stock-info {{ $menu->available ? 'stock-available' : 'stock-unavailable' }}">
                  {{ $menu->available ? $menu->stok . ' available' : 'Out of stock' }}
                </div>
              </div>
            </div>
          </a>
        @endforeach
      </div>

      <!-- Pagination -->
      <div class="pagination-container">
        {{ $menus->links('pagination.custom-black') }}
      </div>
      <div class="results-info" style="text-align:center; margin-top: 10px; color: #fff; font-size: 15px;">
        Showing {{ $menus->firstItem() }} to {{ $menus->lastItem() }} of {{ $menus->total() }} results
      </div>
    </div>
  </div>
</div>

<script>
// Global variables
let currentProducts = [];
let filteredProducts = [];
let carousels = {};

// Global pagination variables
let currentPage = 1;
let itemsPerPage = 9;
let totalPages = 1;

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  // Store all products for filtering
  currentProducts = Array.from(document.querySelectorAll('.product-card'));
  filteredProducts = [...currentProducts];
  
  // Initialize event listeners
  initializeEventListeners();
  
  // Initialize product carousels
  initializeCarousels();
  
  // Calculate initial pagination
  totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
  
  // Initialize pagination
  initializePagination();
  
  // Restore view from session storage
  const savedView = sessionStorage.getItem('productView');
  if (savedView) {
    const viewBtn = document.querySelector(`.view-btn[data-view="${savedView}"]`);
    if (viewBtn) {
      toggleView(savedView, viewBtn);
    }
  }
});

function initializeEventListeners() {
  // Category filtering
  document.querySelectorAll('.category-item').forEach(item => {
    item.addEventListener('click', function() {
      const category = this.getAttribute('data-category');
      filterByCategory(category, this);
    });
  });
  
  // Search functionality
  const searchInput = document.getElementById('searchInput');
  searchInput.addEventListener('input', function() {
    filterBySearch(this.value);
  });
  
  // Sort functionality
  const sortSelect = document.getElementById('sortSelect');
  sortSelect.addEventListener('change', function() {
    sortProducts(this.value);
  });
  
  // Price dropdown filter
  const priceDropdown = document.getElementById('priceDropdown');
  priceDropdown.addEventListener('change', function() {
    applyAllFilters();
  });
  
  // View toggle
  document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const view = this.getAttribute('data-view');
      toggleView(view, this);
    });
  });
  
  // Rating filter
  document.querySelectorAll('.tag').forEach(tag => {
    tag.addEventListener('click', function() {
      // Remove active class from all tags
      document.querySelectorAll('.tag').forEach(t => t.classList.remove('active'));
      
      // Add active class to clicked tag
      this.classList.add('active');
      
      // Get rating value
      const minRating = parseFloat(this.getAttribute('data-rating'));
      
      // Apply all active filters
      applyAllFilters();
    });
  });
}

function filterByCategory(category, element) {
  // Update active state
  document.querySelectorAll('.category-item').forEach(item => {
    item.classList.remove('active');
  });
  element.classList.add('active');
  
  // Apply all filters
  applyAllFilters();
}

function filterBySearch(searchTerm) {
  // Apply all filters
  applyAllFilters();
}

function sortProducts(sortBy) {
  const grid = document.getElementById('productGrid');
  const products = Array.from(grid.children);
  
  products.sort((a, b) => {
    switch(sortBy) {
      case 'name':
        return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
      case 'price-low':
        return parseInt(a.getAttribute('data-price')) - parseInt(b.getAttribute('data-price'));
      case 'price-high':
        return parseInt(b.getAttribute('data-price')) - parseInt(a.getAttribute('data-price'));
      case 'rating':
        return parseFloat(b.getAttribute('data-rating')) - parseFloat(a.getAttribute('data-rating'));
      default:
        return 0;
    }
  });
  
  // Re-append sorted products
  products.forEach(product => grid.appendChild(product));
}

function toggleView(view, element) {
  // Update active button
  document.querySelectorAll('.view-btn').forEach(btn => {
    btn.classList.remove('active');
  });
  element.classList.add('active');
  
  const grid = document.getElementById('productGrid');
  
  // Add transition class
  grid.classList.add('view-transition');
  
  // Store current view in session storage
  sessionStorage.setItem('productView', view);
  
  if (view === 'list') {
    grid.style.gridTemplateColumns = '1fr';
    grid.querySelectorAll('.product-card').forEach(card => {
      if (card.style.display === 'none') return;
      
      // Apply list view styling
      card.classList.add('list-view');
      
      // Reorganize content for list view
      const imageContainer = card.querySelector('.product-image-container');
      const productInfo = card.querySelector('.product-info');
      
      // Set dimensions and layout
      card.style.display = 'flex';
      card.style.flexDirection = 'row';
      card.style.height = '200px';
      card.style.padding = '0';
      
      // Adjust image container
      imageContainer.style.width = '25%';
      imageContainer.style.minWidth = '180px';
      imageContainer.style.height = '100%';
      imageContainer.style.borderRadius = '8px 0 0 8px';
      imageContainer.style.boxShadow = 'inset -10px 0 10px -10px rgba(0,0,0,0.1)';
      imageContainer.style.position = 'relative';
      imageContainer.style.overflow = 'hidden';
      
      // Adjust product info
      productInfo.style.width = '75%';
      productInfo.style.display = 'flex';
      productInfo.style.flexDirection = 'column';
      productInfo.style.justifyContent = 'space-between';
      productInfo.style.padding = '15px 20px';
      
      // Create description element if it doesn't exist
      let descriptionEl = card.querySelector('.product-description');
      if (!descriptionEl) {
        // Get product name to fetch description
        const productName = card.getAttribute('data-name');
        const productCategory = card.getAttribute('data-category');
        

        
        // Create description element
        descriptionEl = document.createElement('div');
        descriptionEl.className = 'product-description';
        descriptionEl.style.fontSize = '14px';
        descriptionEl.style.color = '#666';
        descriptionEl.style.margin = '10px 0';
        descriptionEl.style.lineHeight = '1.4';
        
        // Get description from data attribute
        const productDescription = card.getAttribute('data-description');
        descriptionEl.textContent = productDescription;
        
        // Insert after product title
        const titleEl = productInfo.querySelector('.product-title');
        titleEl.parentNode.insertBefore(descriptionEl, titleEl.nextSibling);
      }
      
      // Add rating display
      let ratingDisplay = card.querySelector('.list-rating-display');
      if (!ratingDisplay) {
        const rating = parseFloat(card.getAttribute('data-rating')) || 0;
        
        // Create rating display
        ratingDisplay = document.createElement('div');
        ratingDisplay.className = 'list-rating-display';
        ratingDisplay.style.display = 'flex';
        ratingDisplay.style.flexDirection = 'column';
        ratingDisplay.style.gap = '5px';
        ratingDisplay.style.marginTop = '10px';
        ratingDisplay.style.marginBottom = '15px';
        
        // Create rating row (stars + text)
        const ratingRow = document.createElement('div');
        ratingRow.style.display = 'flex';
        ratingRow.style.alignItems = 'center';
        ratingRow.style.gap = '5px';
        
        // Create rating stars
        const starsContainer = document.createElement('div');
        starsContainer.style.color = 'rgb(254, 198, 228)';
        starsContainer.style.fontSize = '16px';
        
        // Generate stars based on rating
        let starsHTML = '';
        for (let i = 1; i <= 5; i++) {
          if (i <= Math.floor(rating)) {
            starsHTML += '<i class="fas fa-star"></i>';
          } else if (i - 0.5 <= rating) {
            starsHTML += '<i class="fas fa-star-half-alt"></i>';
          } else {
            starsHTML += '<i class="far fa-star"></i>';
          }
        }
        starsContainer.innerHTML = starsHTML;
        
        // Create rating text
        const ratingText = document.createElement('span');
        ratingText.textContent = `${rating.toFixed(1)} (${Math.floor(Math.random() * 50) + 5} reviews)`;
        ratingText.style.fontSize = '14px';
        ratingText.style.color = '#666';
        
        ratingRow.appendChild(starsContainer);
        ratingRow.appendChild(ratingText);
        
        // Add stock info below rating
        const stockInfo = card.querySelector('.stock-info');
        const stockDiv = document.createElement('div');
        stockDiv.style.fontSize = '12px';
        stockDiv.style.marginTop = '5px';
        if (stockInfo) {
          stockDiv.textContent = stockInfo.textContent;
          stockDiv.className = stockInfo.className;
        }
        
        // Add price below stock info
        const priceEl = card.querySelector('.product-price');
        const priceDiv = document.createElement('div');
        priceDiv.style.fontSize = '16px';
        priceDiv.style.fontWeight = '700';
        priceDiv.style.color = '#fff';
        priceDiv.style.marginTop = '5px';
        if (priceEl) {
          priceDiv.textContent = priceEl.textContent;
        }
        
        ratingDisplay.appendChild(ratingRow);
        ratingDisplay.appendChild(stockDiv);
        ratingDisplay.appendChild(priceDiv);
        
        // Insert after description
        const descriptionEl = card.querySelector('.product-description');
        if (descriptionEl) {
          descriptionEl.parentNode.insertBefore(ratingDisplay, descriptionEl.nextSibling);
        }
        
        // Hide original price
        if (priceEl) {
          priceEl.style.display = 'none';
        }
      }
      
      // Hide original product-meta
      const productMeta = card.querySelector('.product-meta');
      if (productMeta) {
        productMeta.style.display = 'none';
      }
      
      // Add a "Click to view details" message
      let viewDetailsMsg = card.querySelector('.view-details-msg');
      if (!viewDetailsMsg) {
        viewDetailsMsg = document.createElement('div');
        viewDetailsMsg.className = 'view-details-msg';
        viewDetailsMsg.style.textAlign = 'center';
        viewDetailsMsg.style.color = '#666';
        viewDetailsMsg.style.fontSize = '13px';
        viewDetailsMsg.style.marginTop = '15px';
        viewDetailsMsg.style.fontStyle = 'italic';
        
        // Insert before product meta
        const metaEl = productInfo.querySelector('.product-meta');
        productInfo.insertBefore(viewDetailsMsg, metaEl);
      }
    });
  } else {
    grid.style.gridTemplateColumns = 'repeat(auto-fill, minmax(280px, 1fr))';
    grid.querySelectorAll('.product-card').forEach(card => {
      if (card.style.display === 'none') return;
      
      // Remove list view styling
      card.classList.remove('list-view');
      
      // Reset to grid view
      card.style.display = 'block';
      card.style.flexDirection = '';
      card.style.height = '';
      card.style.padding = '';
      
      // Reset image container
      const imageContainer = card.querySelector('.product-image-container');
      imageContainer.style.width = '';
      imageContainer.style.minWidth = '';
      imageContainer.style.height = '250px';
      imageContainer.style.borderRadius = '';
      
      // Reset product info
      const productInfo = card.querySelector('.product-info');
      productInfo.style.width = '';
      productInfo.style.display = '';
      productInfo.style.flexDirection = '';
      productInfo.style.justifyContent = '';
      productInfo.style.padding = '20px';
      
      // Remove list-view specific elements
      const descriptionEl = card.querySelector('.product-description');
      if (descriptionEl) {
        descriptionEl.remove();
      }
      

      
      const ratingDisplay = card.querySelector('.list-rating-display');
      if (ratingDisplay) {
        ratingDisplay.remove();
      }
      
      const viewDetailsMsg = card.querySelector('.view-details-msg');
      if (viewDetailsMsg) {
        viewDetailsMsg.remove();
      }
      
      // Show original product-meta and price
      const productMeta = card.querySelector('.product-meta');
      if (productMeta) {
        productMeta.style.display = 'flex';
      }
      
      const priceEl = card.querySelector('.product-price');
      if (priceEl) {
        priceEl.style.display = 'block';
      }
    });
  }
  
  // Complete the transition effect
  setTimeout(() => {
    grid.classList.add('view-transition-end');
    setTimeout(() => {
      grid.classList.remove('view-transition');
      grid.classList.remove('view-transition-end');
    }, 300);
  }, 50);
}

function updateResultsCount() {
  // Get all visible products after filtering
  filteredProducts = currentProducts.filter(card => {
    const computedStyle = window.getComputedStyle(card);
    return computedStyle.display !== 'none';
  });
  
  const total = filteredProducts.length;
  
  // Update total pages
  totalPages = Math.max(1, Math.ceil(total / itemsPerPage));
  
  // Ensure current page is valid
  if (currentPage > totalPages) {
    currentPage = Math.max(1, totalPages);
  }
  
  // Update pagination UI
  updatePaginationUI();
  
  // Show products for current page
  showProductsForCurrentPage();
}

function filterByRating(minRating) {
  currentProducts.forEach(card => {
    // If minRating is 0, show all products
    if (minRating === 0) {
      card.style.display = '';
      return;
    }
    
    const rating = parseFloat(card.getAttribute('data-rating')) || 0;
    
    if (rating >= minRating) {
      card.style.display = '';
    } else {
      card.style.display = 'none';
    }
  });
  
  updateResultsCount();
}

function applyAllFilters() {
  // Reset all products to visible (for filtering purposes)
  currentProducts.forEach(card => {
    card.style.display = '';
  });
  
  // Apply category filter
  const activeCategory = document.querySelector('.category-item.active').getAttribute('data-category');
  if (activeCategory !== 'all') {
    currentProducts.forEach(card => {
      const cardCategory = card.getAttribute('data-category');
      if (cardCategory !== activeCategory) {
        card.style.display = 'none';
      }
    });
  }
  
  // Apply rating filter
  const activeRating = parseFloat(document.querySelector('.tag.active').getAttribute('data-rating'));
  if (activeRating > 0) {
    currentProducts.forEach(card => {
      if (card.style.display !== 'none') {
        const rating = parseFloat(card.getAttribute('data-rating')) || 0;
        if (rating < activeRating) {
          card.style.display = 'none';
        }
      }
    });
  }
  
  // Apply price filter
  const priceFilter = document.getElementById('priceDropdown').value;
  if (priceFilter !== 'all') {
    currentProducts.forEach(card => {
      if (card.style.display !== 'none') {
        const price = parseInt(card.getAttribute('data-price'));
        const [minPrice, maxPrice] = priceFilter.split('-').map(p => parseInt(p));
        
        if (price < minPrice || price > maxPrice) {
          card.style.display = 'none';
        }
      }
    });
    
    // Filter top products
    document.querySelectorAll('.top-product-item').forEach(item => {
      const price = parseInt(item.getAttribute('data-price'));
      const [minPrice, maxPrice] = priceFilter.split('-').map(p => parseInt(p));
      
      if (price < minPrice || price > maxPrice) {
        item.style.display = 'none';
      } else {
        item.style.display = 'flex';
      }
    });
  } else {
    // Show all top products when no price filter
    document.querySelectorAll('.top-product-item').forEach(item => {
      item.style.display = 'flex';
    });
  }
  
  // Apply search filter
  const searchTerm = document.getElementById('searchInput').value.toLowerCase();
  if (searchTerm) {
    currentProducts.forEach(card => {
      if (card.style.display !== 'none') {
        const name = card.getAttribute('data-name');
        if (!name.includes(searchTerm)) {
          card.style.display = 'none';
        }
      }
    });
  }
  
  // Reset to first page when filters change
  currentPage = 1;
  
  // Update results count and pagination
  updateResultsCount();
}

// Product Image Carousel Functions
function initializeCarousels() {
  const carouselContainers = document.querySelectorAll('.carousel-container');
  
  carouselContainers.forEach(container => {
    const productId = container.getAttribute('data-product-id');
    const slides = container.querySelectorAll('.carousel-slide');
    const imageContainer = container.closest('.product-image-container');
    
    // Only initialize if there are multiple slides
    if (slides.length > 1) {
      const prevBtn = container.querySelector('.prev-btn');
      const nextBtn = container.querySelector('.next-btn');
      const dots = container.querySelectorAll('.carousel-dot');
      
      // Store carousel data
      carousels[productId] = {
        container,
        slides,
        dots,
        currentIndex: 0,
        totalSlides: slides.length,
        interval: null
      };
      
      // Add event listeners
      if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          navigateCarousel(productId, 'prev');
        });
      }
      
      if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          navigateCarousel(productId, 'next');
        });
      }
      
      dots.forEach((dot, index) => {
        dot.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          goToSlide(productId, index);
        });
      });
      
      // Add hover events for auto-cycling on image container
      if (imageContainer) {
        imageContainer.addEventListener('mouseenter', function() {
          startCarouselAutoplay(productId);
        });
        
        imageContainer.addEventListener('mouseleave', function() {
          stopCarouselAutoplay(productId);
        });
      }
    }
  });
}

function navigateCarousel(productId, direction) {
  const carousel = carousels[productId];
  if (!carousel) return;
  
  let newIndex = carousel.currentIndex;
  
  if (direction === 'next') {
    newIndex = (newIndex + 1) % carousel.totalSlides;
  } else {
    newIndex = (newIndex - 1 + carousel.totalSlides) % carousel.totalSlides;
  }
  
  goToSlide(productId, newIndex);
}

function goToSlide(productId, index) {
  const carousel = carousels[productId];
  if (!carousel) return;
  
  // Update slides
  carousel.slides.forEach((slide, i) => {
    slide.classList.toggle('active', i === index);
  });
  
  // Update dots
  carousel.dots.forEach((dot, i) => {
    dot.classList.toggle('active', i === index);
  });
  
  // Update current index
  carousel.currentIndex = index;
}

function startCarouselAutoplay(productId) {
  const carousel = carousels[productId];
  if (!carousel) return;
  
  // Clear any existing interval
  stopCarouselAutoplay(productId);
  
  // Start new interval
  carousel.interval = setInterval(() => {
    const nextIndex = (carousel.currentIndex + 1) % carousel.totalSlides;
    goToSlide(productId, nextIndex);
  }, 1500); // Change slide every 1.5 seconds
}

function stopCarouselAutoplay(productId) {
  const carousel = carousels[productId];
  if (!carousel) return;
  
  if (carousel.interval) {
    clearInterval(carousel.interval);
    carousel.interval = null;
  }
}

// Pagination Functions
function initializePagination() {
  // Update pagination UI
  updatePaginationUI();
  
  // Show first page
  showProductsForCurrentPage();
}

function updatePaginationUI() {
  const pagination = document.getElementById('pagination');
  if (!pagination) return;

  // Remove all existing page buttons
  Array.from(pagination.querySelectorAll('.page-btn'))
    .filter(btn => btn.hasAttribute('data-page'))
    .forEach(btn => btn.remove());

  // Get prev and next buttons
  const prevBtn = pagination.querySelector('[data-action="prev"]');
  const nextBtn = pagination.querySelector('[data-action="next"]');

  if (!prevBtn || !nextBtn) return;

  // Update prev/next button states
  prevBtn.disabled = currentPage <= 1;
  nextBtn.disabled = currentPage >= totalPages || totalPages <= 1;
  
  prevBtn.style.opacity = prevBtn.disabled ? '0.5' : '1';
  nextBtn.style.opacity = nextBtn.disabled ? '0.5' : '1';

  // Add page buttons
  for (let i = 1; i <= totalPages; i++) {
    const pageBtn = document.createElement('button');
    pageBtn.className = `page-btn${i === currentPage ? ' active' : ''}`;
    pageBtn.setAttribute('data-page', i);
    pageBtn.textContent = i;
    pagination.insertBefore(pageBtn, nextBtn);
    
    pageBtn.addEventListener('click', function(e) {
      e.preventDefault();
      goToPage(i);
    });
  }

  // Add event listeners for prev/next
  prevBtn.onclick = function(e) {
    e.preventDefault();
    if (!prevBtn.disabled) goToPage(currentPage - 1);
  };
  
  nextBtn.onclick = function(e) {
    e.preventDefault();
    if (!nextBtn.disabled) goToPage(currentPage + 1);
  };
}

function goToPage(page) {
  currentPage = page;
  
  // Update active page button
  document.querySelectorAll('.page-btn').forEach(btn => {
    const btnPage = parseInt(btn.getAttribute('data-page'));
    if (btnPage === currentPage) {
      btn.classList.add('active');
    } else {
      btn.classList.remove('active');
    }
  });
  
  // Show products for current page
  showProductsForCurrentPage();
  
  // Update pagination UI
  updatePaginationUI();
  
  // Scroll to top of product grid
  const grid = document.getElementById('productGrid');
  if (grid) {
    grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}

function showProductsForCurrentPage() {
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;

  // Hide all products first
  currentProducts.forEach(product => {
    product.style.display = 'none';
  });

  // Show only the products for the current page
  const productsToShow = filteredProducts.slice(startIndex, endIndex);
  
  productsToShow.forEach(product => {
    // Check if we're in list or grid view
    const isListView = document.querySelector('.view-btn[data-view="list"]')?.classList.contains('active');
    
    if (isListView && product.classList.contains('list-view')) {
      product.style.display = 'flex';
    } else if (!isListView && !product.classList.contains('list-view')) {
      product.style.display = 'block';
    } else if (isListView) {
      product.style.display = 'flex';
    } else {
      product.style.display = 'block';
    }
  });

  // Update results info
  const totalVisible = filteredProducts.length;
  const start = totalVisible > 0 ? startIndex + 1 : 0;
  const end = Math.min(endIndex, totalVisible);

  document.getElementById('resultStart').textContent = start;
  document.getElementById('resultEnd').textContent = end;
  document.getElementById('totalResults').textContent = totalVisible;
}
</script>

@endsection