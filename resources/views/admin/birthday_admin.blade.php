@extends('layouts.app')

@section('content')

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
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
    }

    .btn-add {
        background-color: #e67e22;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
        margin-top: 10px;
    }

    .btn-add:hover {
        background-color: #d35400;
    }

    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        padding: 30px;
        justify-content: center;
    }

    .card {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        width: 260px;
    }

    .card-img-container {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Carousel styles */
    .image-carousel {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .carousel-inner {
        display: flex;
        transition: transform 0.5s ease;
        height: 100%;
    }

    .carousel-item {
        min-width: 100%;
        height: 100%;
    }

    .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .carousel-control {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0,0,0,0.5);
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 2;
        font-weight: bold;
    }

    .carousel-control-prev {
        left: 10px;
    }

    .carousel-control-next {
        right: 10px;
    }

    .card-body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 8px;
        color: #2c3e50;
    }

    .card-text {
        font-size: 14px;
        color: #7f8c8d;
        margin-bottom: 8px;
    }

    .card-price {
        font-weight: bold;
        font-size: 16px;
        color: #e67e22;
        margin-bottom: 12px;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
    }

    .btn-sm {
        font-size: 14px;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-warning {
        background-color: #f1c40f;
        color: #2c3e50;
    }

    .btn-danger {
        background-color: #e74c3c;
        color: #fff;
    }

    .alert {
        max-width: 700px;
        margin: 20px auto;
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
    }

    .badge-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .badge-available {
        background-color: #2ecc71;
        color: white;
    }

    .badge-unavailable {
        background-color: #e74c3c;
        color: white;
    }
</style>

@section('header')
    <h1 class="text-center font-bold text-xl py-4">Daftar Kue Ulang Tahun</h1>
@endsection

<div class="header-area">
    <a href="{{ route('birthday.create') }}?type=birthday" class="btn-add">Tambah Kue Ulang Tahun</a>
</div>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

<div class="product-grid">
    @foreach($birthdayCakes as $cake)
    <div class="card">
        <div class="image-carousel" id="carousel-{{ $cake->id }}">
            @if($cake->images)
                <div class="carousel-inner">
                    @php
                        $images = json_decode($cake->images);
                    @endphp
                    @foreach($images as $index => $imagePath)
                        <div class="carousel-item" data-index="{{ $index }}">
                            <img src="{{ asset('storage/'.$imagePath) }}" alt="{{ $cake->name }} image {{ $index + 1 }}">
                        </div>
                    @endforeach
                </div>
                @if(count($images) > 1)
                    <button class="carousel-control carousel-control-prev" onclick="prevSlide('carousel-{{ $cake->id }}')">&#10094;</button>
                    <button class="carousel-control carousel-control-next" onclick="nextSlide('carousel-{{ $cake->id }}')">&#10095;</button>
                @endif
            @else
                <img src="https://via.placeholder.com/300x220?text=No+Image" alt="No image">
            @endif
        </div>

        <div class="card-body">
            <div class="card-title">{{ $cake->name }}</div>
            <div>
                <span class="badge-status {{ $cake->available ? 'badge-available' : 'badge-unavailable' }}">
                    {{ $cake->available ? 'Tersedia' : 'Tidak Tersedia' }}
                </span>
            </div>
            <div class="card-text">{{ Str::limit($cake->description, 100) }}</div>
            <div class="card-text"><strong>Rasa:</strong> {{ $cake->flavor ?? '-' }}</div>
            <div class="card-text"><strong>Stok:</strong> {{ $cake->stok }} pcs</div>
            <div class="card-price">Rp {{ number_format($cake->price, 0, ',', '.') }}</div>

            <div class="btn-group">
                <a href="{{ route('menus.edit', $cake->id) }}" class="btn-sm btn-warning">Edit</a>
                <form action="{{ route('menus.destroy', $cake->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus kue ulang tahun?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sm btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>
    // Carousel functionality for multiple images
    function initCarousels() {
        // Initialize all carousels with their first slide
        const carousels = document.querySelectorAll('.image-carousel');
        carousels.forEach(carousel => {
            const id = carousel.id;
            window[id] = { currentIndex: 0 };
        });
    }

    function showSlide(carouselId, index) {
        const carousel = document.getElementById(carouselId);
        const inner = carousel.querySelector('.carousel-inner');
        const items = inner.querySelectorAll('.carousel-item');

        if (!items.length) return;

        if (index >= items.length) {
            window[carouselId].currentIndex = 0;
        } else if (index < 0) {
            window[carouselId].currentIndex = items.length - 1;
        } else {
            window[carouselId].currentIndex = index;
        }

        inner.style.transform = `translateX(-${window[carouselId].currentIndex * 100}%)`;
    }

    function nextSlide(carouselId) {
        showSlide(carouselId, window[carouselId].currentIndex + 1);
    }

    function prevSlide(carouselId) {
        showSlide(carouselId, window[carouselId].currentIndex - 1);
    }

    // Initialize all carousels when the page loads
    document.addEventListener('DOMContentLoaded', initCarousels);
</script>
@endsection