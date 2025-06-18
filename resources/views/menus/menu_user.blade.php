@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #ffffff;
    margin: 0;
    padding: 0;
  }

  /* Hero Section */
  .hero-section {
    background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2072&q=80');
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
    max-width: 1200px;
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
    flex: 1;
    max-width: 300px;
  }

  .search-input {
    width: 100%;
    padding: 12px 20px;
    border: 1px solid #ddd;
    border-radius: 25px;
    font-size: 14px;
    outline: none;
  }

  .search-input:focus {
    border-color: #d4a574;
    box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
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

  .sort-select {
    padding: 8px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: white;
    cursor: pointer;
  }

  .view-toggle {
    display: flex;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }

  .view-btn {
    padding: 8px 12px;
    background: white;
    border: none;
    cursor: pointer;
    color: #666;
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
    background: #d4a574;
    color: white;
    box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
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
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
  }

  .sidebar-section h3 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
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
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: color 0.3s;
  }

  .category-item:hover {
    color: #d4a574;
  }

  .category-item.active {
    color: #d4a574;
    font-weight: 600;
  }

  .category-count {
    background: #e9ecef;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
    color: #666;
  }

  /* Price Filter */
  .price-filter {
    margin: 15px 0;
  }

  .price-range {
    width: 100%;
    margin: 10px 0;
  }

  .price-values {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #666;
    margin-bottom: 10px;
  }

  .filter-btn {
    background: #d4a574;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
  }

  /* Top Products */
  .top-product-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
  }

  .top-product-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
  }

  .top-product-info h4 {
    font-size: 14px;
    margin: 0 0 5px 0;
    color: #333;
  }

  .top-product-price {
    font-size: 12px;
    color: #d4a574;
    font-weight: 600;
  }

  /* Tags */
  .tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }

  .tag {
    background: #e9ecef;
    color: #666;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s;
    margin-bottom: 8px;
    display: inline-block;
  }

  .tag:hover {
    background: #d4a574;
    color: white;
  }
  
  .tag.active {
    background: #d4a574;
    color: white;
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
    background: white;
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
    border-left: 4px solid #d4a574;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    position: relative;
    overflow: visible;
    animation: fadeInUp 0.5s ease-out;
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
    color: #333;
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
    background-color: #d4a574;
    transition: width 0.3s ease;
  }
  
  .product-card.list-view:hover .product-title::after {
    width: 100%;
  }
  
  .product-card.list-view .product-price {
    font-size: 18px;
    color: #d4a574;
    margin: 5px 0;
    font-weight: 700;
  }
  
  .product-card.list-view .product-meta {
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px;
    border-top: 1px dashed #eee;
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
    background: #d4a574;
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
    color: #333;
  }

  .product-price {
    font-size: 16px;
    font-weight: 700;
    color: #d4a574;
    margin-bottom: 10px;
  }

  .product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: #666;
  }

  .product-rating {
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .rating-stars {
    color: #ffc107;
  }

  .stock-info {
    font-size: 12px;
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
  }

  .page-btn {
    width: 40px;
    height: 40px;
    border: 1px solid #ddd;
    background: white;
    color: #666;
    border-radius: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
  }

  .page-btn:hover,
  .page-btn.active {
    background: #d4a574;
    color: white;
    border-color: #d4a574;
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
    <div class="breadcrumb-nav">
      <a href="/">Home</a>
      <span>></span>
      <span>Product</span>
    </div>
  </div>
</div>

<div class="main-container">
  <!-- Top Controls -->
  <div class="top-controls">
    <div class="search-container">
      <input type="text" class="search-input" placeholder="Search..." id="searchInput">
    </div>
    
    <div class="results-info">
      Showing <span id="resultStart">1</span>-<span id="resultEnd">12</span> of <span id="totalResults">{{ count($menus) }}</span> results
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
          @php
            $categories = ['Roti Manis', 'Roti Tawar', 'Kue (Cake)', 'Donat', 'Pastry'];
            $categoryCounts = [];
            foreach($categories as $cat) {
              $slug = Str::slug($cat, '-');
              $count = $menus->where('kategori', $cat)->count();
              $categoryCounts[$slug] = $count;
            }
          @endphp
          
          <li class="category-item active" data-category="all">
            <span>All Products</span>
            <span class="category-count">{{ count($menus) }}</span>
          </li>
          
          @foreach($categories as $cat)
            @php
              $slug = Str::slug($cat, '-');
              $count = $categoryCounts[$slug] ?? 0;
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
        <h3>Filter by price</h3>
        <div class="price-filter">
          <div class="price-values">
            <span>Price: Rp <span id="minPrice">0</span> — Rp <span id="maxPrice">100000</span></span>
          </div>
          <input type="range" class="price-range" id="priceRange" min="0" max="100000" value="100000">
          <button class="filter-btn" onclick="applyPriceFilter()">Filter</button>
        </div>
      </div>

      <!-- Top Products -->
      <div class="sidebar-section">
        <h3>Top product</h3>
        @php
          $topProducts = $menus->sortByDesc(function($menu) {
            return $menu->reviews->avg('rating') ?? 0;
          })->take(4);
        @endphp
        
        @foreach($topProducts as $product)
          <div class="top-product-item">
            @php
              $image = null;
              if($product->images) {
                $images = json_decode($product->images);
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
          </div>
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
              $images = json_decode($menu->images);
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
             data-rating="{{ $avgRating }}">
            
            <div class="product-image-container">
              @if($menu->images)
                @php
                  $images = json_decode($menu->images);
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
              <h3 class="product-title">{{ $menu->name }}</h3>
              <div class="product-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
              <div class="product-meta">
                <div class="product-rating">
                  <span class="rating-stars">★</span>
                  <span>{{ $avgRating ?: '0.0' }}</span>
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
        <div class="pagination" id="pagination">
          <button class="page-btn" data-action="prev">&laquo;</button>
          <button class="page-btn active" data-page="1">1</button>
          <button class="page-btn" data-page="2">2</button>
          <button class="page-btn" data-page="3">3</button>
          <button class="page-btn" data-page="4">4</button>
          <button class="page-btn" data-page="5">5</button>
          <button class="page-btn" data-action="next">&raquo;</button>
        </div>
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
let itemsPerPage = 12;
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
  
  // Update results count
  updateResultsCount();
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
  
  // Price range
  const priceRange = document.getElementById('priceRange');
  priceRange.addEventListener('input', function() {
    document.getElementById('maxPrice').textContent = parseInt(this.value).toLocaleString();
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

function applyPriceFilter() {
  // Apply all filters
  applyAllFilters();
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
      card.style.height = '180px';
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
        
        // Create category badge
        const categoryBadge = document.createElement('span');
        categoryBadge.className = 'category-badge';
        categoryBadge.textContent = productCategory.replace(/-/g, ' ');
        categoryBadge.style.display = 'inline-block';
        categoryBadge.style.padding = '3px 8px';
        categoryBadge.style.backgroundColor = '#f8f9fa';
        categoryBadge.style.color = '#666';
        categoryBadge.style.borderRadius = '12px';
        categoryBadge.style.fontSize = '11px';
        categoryBadge.style.fontWeight = '600';
        categoryBadge.style.textTransform = 'uppercase';
        categoryBadge.style.letterSpacing = '0.5px';
        categoryBadge.style.marginLeft = '10px';
        categoryBadge.style.verticalAlign = 'middle';
        
        // Create description element
        descriptionEl = document.createElement('div');
        descriptionEl.className = 'product-description';
        descriptionEl.style.fontSize = '14px';
        descriptionEl.style.color = '#666';
        descriptionEl.style.margin = '10px 0';
        descriptionEl.style.lineHeight = '1.4';
        
        // Add description text (this would ideally come from your database)
        descriptionEl.textContent = `Delicious ${productName} from our collection. Perfect for any occasion.`;
        
        // Insert after product title
        const titleEl = productInfo.querySelector('.product-title');
        titleEl.appendChild(categoryBadge);
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
        ratingDisplay.style.alignItems = 'center';
        ratingDisplay.style.gap = '5px';
        ratingDisplay.style.marginTop = '10px';
        ratingDisplay.style.marginBottom = '15px';
        
        // Create rating stars
        const starsContainer = document.createElement('div');
        starsContainer.style.color = '#ffc107';
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
        
        ratingDisplay.appendChild(starsContainer);
        ratingDisplay.appendChild(ratingText);
        
        // Insert after description
        const descriptionEl = card.querySelector('.product-description');
        if (descriptionEl) {
          descriptionEl.parentNode.insertBefore(ratingDisplay, descriptionEl.nextSibling);
        }
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
  filteredProducts = currentProducts.filter(card => card.style.display !== 'none');
  const total = filteredProducts.length;
  
  // Update total pages
  totalPages = Math.ceil(total / itemsPerPage);
  
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
  const maxPrice = parseInt(document.getElementById('priceRange').value);
  currentProducts.forEach(card => {
    if (card.style.display !== 'none') {
      const price = parseInt(card.getAttribute('data-price'));
      if (price > maxPrice) {
        card.style.display = 'none';
      }
    }
  });
  
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
  // Calculate total pages
  totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
  
  // Update pagination UI
  updatePaginationUI();
  
  // Add event listeners to pagination buttons
  document.querySelectorAll('.page-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const action = this.getAttribute('data-action');
      const page = parseInt(this.getAttribute('data-page'));
      
      if (action === 'prev') {
        if (currentPage > 1) {
          goToPage(currentPage - 1);
        }
      } else if (action === 'next') {
        if (currentPage < totalPages) {
          goToPage(currentPage + 1);
        }
      } else if (page) {
        goToPage(page);
      }
    });
  });
  
  // Show first page
  goToPage(1);
}

function updatePaginationUI() {
  const pagination = document.getElementById('pagination');
  if (!pagination) return;
  
  // Clear existing page buttons (except first, prev, next, last)
  const pageButtons = Array.from(pagination.querySelectorAll('.page-btn')).filter(btn => 
    !btn.hasAttribute('data-action')
  );
  
  pageButtons.forEach(btn => btn.remove());
  
  // Get prev and next buttons
  const prevBtn = pagination.querySelector('[data-action="prev"]');
  const nextBtn = pagination.querySelector('[data-action="next"]');
  
  // Disable/enable prev/next buttons
  prevBtn.disabled = currentPage === 1;
  nextBtn.disabled = currentPage === totalPages;
  
  // Add page buttons
  const maxVisiblePages = 5;
  let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
  let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
  
  if (endPage - startPage + 1 < maxVisiblePages) {
    startPage = Math.max(1, endPage - maxVisiblePages + 1);
  }
  
  // Insert page buttons before the next button
  for (let i = startPage; i <= endPage; i++) {
    const pageBtn = document.createElement('button');
    pageBtn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
    pageBtn.setAttribute('data-page', i);
    pageBtn.textContent = i;
    
    pagination.insertBefore(pageBtn, nextBtn);
  }
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
  filteredProducts.slice(startIndex, endIndex).forEach(product => {
    // Check if we're in list or grid view
    const isListView = document.querySelector('.view-btn[data-view="list"]').classList.contains('active');
    if (isListView) {
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