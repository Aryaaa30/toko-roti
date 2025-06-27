@extends('layouts.app')

@section('content')

<style>
    :root {
        --bg-dark: rgb(0, 0, 0);
        --card-bg: rgb(18, 18, 18);
        --border-color: rgb(40, 40, 40);
        --text-base: rgb(245, 245, 245);
        --text-important: rgb(254, 198, 228); /* Pastel Pink */
        --text-secondary: #b0b0b0;
        --text-white: #ffffff;
    }

    body {
        background-color: var(--bg-dark);
        font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
        color: var(--text-base);
    }

    /* --- Area Header --- */
    .header-area {
        text-align: center;
        padding: 40px 20px 30px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 30px;
    }

    .header-area h1 {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-important);
        margin-bottom: 15px;
    }

    .btn-add {
        background-color: var(--text-important);
        color: var(--bg-dark);
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 700;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .btn-add:hover {
        background-color: var(--text-white);
    }

    /* --- Layout Daftar Produk (Horizontal) --- */
    .product-list-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .product-item {
        display: flex;
        align-items: center;
        gap: 20px;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        transition: border-color 0.3s ease;
    }

    .product-item:hover {
        border-color: var(--text-important);
    }

    /* --- Gambar Produk & Carousel --- */
    .item-image {
        width: 150px;
        height: 150px;
        flex-shrink: 0;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .item-image .image-carousel,
    .item-image .card-img-container,
    .item-image .carousel-inner,
    .item-image .carousel-item,
    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .carousel-control {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.6);
        color: var(--text-white);
        border: none;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 2;
        font-weight: bold;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .item-image:hover .carousel-control {
        opacity: 1;
    }

    .carousel-control-prev { left: 8px; }
    .carousel-control-next { right: 8px; }

    /* --- Detail Produk --- */
    .item-details {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .item-details .item-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-base);
    }

    .item-details .item-description {
        font-size: 14px;
        color: var(--text-secondary);
    }

    .item-details .item-meta {
        font-size: 14px;
        color: var(--text-base);
    }

    .item-price {
        font-size: 18px;
        font-weight: bold;
        color: var(--text-important);
        margin-top: 8px;
    }

    /* --- Lencana Status --- */
    .badge-status {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: bold;
    }

    .badge-available {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }

    .badge-unavailable {
        background-color: var(--border-color);
        color: var(--text-secondary);
    }

    /* --- Tombol Aksi --- */
    .item-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-shrink: 0;
    }

    .btn-action {
        padding: 8px 20px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 6px;
        text-align: center;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        min-width: 100px; /* Lebar tombol sama */
    }

    /* Tombol Edit */
    .btn-edit {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }
    .btn-edit:hover {
        background-color: var(--text-white);
    }

    /* Tombol Hapus */
    .btn-delete {
        background-color: var(--bg-dark);
        color: var(--text-important);
        border: 1px solid var(--text-important);
    }
    .btn-delete:hover {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }

    /* Tombol Tambah ke Keranjang */
    .btn-add-cart {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }
     .btn-add-cart:hover {
        background-color: var(--text-white);
    }


    .alert {
        max-width: 1160px;
        margin: 20px auto;
        background-color: var(--card-bg);
        color: var(--text-base);
        padding: 15px 20px;
        border-radius: 8px;
        border-left: 5px solid var(--text-important);
    }

</style>

<div class="header-area">
    <h1>Daftar Produk Roti</h1>
    @if(auth()->user()->is_admin)
        <a href="{{ route('menus.create') }}" class="btn-add">Tambah Produk</a>
    @endif
</div>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

<div class="product-list-container">
    @foreach($menus as $menu)
    <div class="product-item">
        <div class="item-image">
            <div class="image-carousel" id="carousel-{{ $menu->id }}">
                @php
                    $images = [];
                    if ($menu->images) {
                        $decoded = json_decode($menu->images, true);
                        if (is_array($decoded) && count($decoded) > 0) {
                            $images = $decoded;
                        }
                    }
                @endphp
                
                @if(count($images) > 0)
                    <div class="carousel-inner">
                        @foreach($images as $index => $imagePath)
                            @if($imagePath && !empty(trim($imagePath)))
                                <div class="carousel-item" data-index="{{ $index }}">
                                    <img src="{{ asset('storage/'.$imagePath) }}" alt="..." onerror="this.src='https://via.placeholder.com/150x150?text=Image+Error'">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if(count($images) > 1)
                        <button class="carousel-control carousel-control-prev" onclick="prevSlide('carousel-{{ $menu->id }}')">&#10094;</button>
                        <button class="carousel-control carousel-control-next" onclick="nextSlide('carousel-{{ $menu->id }}')">&#10095;</button>
                    @endif
                @elseif($menu->image)
                    <div class="card-img-container">
                        <img src="{{ asset('storage/'.$menu->image) }}" 
                             alt="{{ $menu->name }}"
                             onerror="this.src='https://via.placeholder.com/150x150?text=Image+Error'">
                    </div>
                @else
                    <div class="card-img-container">
                        <img src="https://via.placeholder.com/150x150?text=No+Image" alt="No image available">
                    </div>
                @endif
            </div>
        </div>

        <div class="item-details">
            <div class="item-title">{{ $menu->name }}</div>
            <div>
                @if(isset($menu->available))
                    <span class="badge-status {{ $menu->available ? 'badge-available' : 'badge-unavailable' }}">
                        {{ $menu->available ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                @endif
            </div>
            <p class="item-description">{{ Str::limit($menu->description, 150) }}</p>
            <div class="item-meta">
                <strong>Kategori:</strong> {{ $menu->kategori }} | <strong>Stok:</strong> {{ $menu->stok }} pcs
            </div>
            <div class="item-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
        </div>

        <div class="item-actions">
            @if(auth()->user()->is_admin)
                <a href="{{ route('menus.edit', $menu->id) }}" class="btn-action btn-edit">Edit</a>
                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete">Hapus</button>
                </form>
            @else
                <form action="{{ route('carts.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    <button type="submit" class="btn-action btn-add-cart">Tambah ke Keranjang</button>
                </form>
            @endif
        </div>
    </div>
    @endforeach
</div>

<script>
    const carousels = {};

    function initCarousels() {
        const carouselElements = document.querySelectorAll('.image-carousel');
        carouselElements.forEach(carousel => {
            const id = carousel.id;
            carousels[id] = { currentIndex: 0 };
            showSlide(id, 0);
        });
    }

    function showSlide(carouselId, index) {
        const carousel = document.getElementById(carouselId);
        if (!carousel) return;
        
        const inner = carousel.querySelector('.carousel-inner');
        if (!inner) return;

        const items = inner.querySelectorAll('.carousel-item');
        const state = carousels[carouselId];

        if (!items.length) return;

        if (index >= items.length) {
            state.currentIndex = 0;
        } else if (index < 0) {
            state.currentIndex = items.length - 1;
        } else {
            state.currentIndex = index;
        }

        inner.style.transform = `translateX(-${state.currentIndex * 100}%)`;
    }

    function nextSlide(carouselId) {
        const state = carousels[carouselId];
        showSlide(carouselId, state.currentIndex + 1);
    }

    function prevSlide(carouselId) {
        const state = carousels[carouselId];
        showSlide(carouselId, state.currentIndex - 1);
    }

    document.addEventListener('DOMContentLoaded', initCarousels);
</script>

@endsection