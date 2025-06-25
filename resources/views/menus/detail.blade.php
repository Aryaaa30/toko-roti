@extends('layouts.app')

@section('content')
<style>
body {
  background: #000000;
}

.container {
  max-width: 1200px;
  margin: 32px auto;
  padding: 32px 24px;
}

.main-content {
  display: flex;
  gap: 24px;
  align-items: flex-start;
}

/* Card Kiri - Foto dan Atribut Produk */
.left-card {
  flex: 1;

  border-radius: 16px;
 margin-top: 1rem;
  box-shadow: 0 4px 32px rgba(0,0,0,0.3);
  display: flex;
  gap: 32px;
  
}

.image-section {
  flex: 0 0 400px;
  max-width: 400px;
}

.image-carousel {
  width: 100%;
  aspect-ratio: 1/1.15;
  background: #000000;
  border-radius: 14px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 18px;
  overflow: hidden;
  position: relative;
  border: 1px solid #222;
}

.carousel-inner {
  display: flex;
  transition: transform 0.5s ease;
  width: 100%;
  height: 100%;
}

.carousel-item {
  min-width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.carousel-control {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(254, 198, 228, 0.8);
  color: #111;
  border: none;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 2;
  opacity: 0.8;
  transition: opacity 0.3s;
  font-weight: bold;
}

.carousel-control:hover {
  opacity: 1;
  background: rgb(254, 198, 228);
}

.carousel-control-prev {
  left: 10px;
}

.carousel-control-next {
  right: 10px;
}

.image-carousel img, .main-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  background: #222;
  border-radius: 14px;
}

/* Thumbnail container */
.thumbnail-container {
  display: flex;
  gap: 12px;
  width: 100%;
  justify-content: center;
  flex-wrap: nowrap;
  max-width: 100%;
  /* Width depends on number of visible thumbnails */
  width: calc(var(--visible-thumbs) * (70px + 12px) - 12px);
  margin: 0 auto;
}

/* Scrollable thumbnail container if more than 5 thumbnails */
.thumbnail-container.scrollable {
  overflow-x: auto;
  scrollbar-width: thin;
  scrollbar-color: rgba(254, 198, 228, 0.8) transparent;
  /* Hide vertical scrollbar */
  overflow-y: hidden;
}

/* For Webkit browsers */
.thumbnail-container.scrollable::-webkit-scrollbar {
  height: 6px;
}

.thumbnail-container.scrollable::-webkit-scrollbar-thumb {
  background-color: rgba(254, 198, 228, 0.8);
  border-radius: 3px;
}

.thumbnail {
  /* Width and height fixed at 70px */
  width: 70px;
  height: 70px;
  border-radius: 10px;
  object-fit: cover;
  cursor: pointer;
  border: 2px solid #333;
  background: #222;
  transition: border 0.2s, box-shadow 0.2s, transform 0.2s;
  box-shadow: 0 1px 4px rgba(0,0,0,0.4);
  flex-shrink: 0;
}

/* Adjust thumbnail size if less than 5 thumbnails */
.thumbnail-container:not(.scrollable) .thumbnail {
  width: calc((100% - (var(--visible-thumbs) - 1) * 12px) / var(--visible-thumbs));
  height: auto;
  aspect-ratio: 1 / 1;
}

.thumbnail.active, .thumbnail:hover {
  border-color: rgb(254, 198, 228);
  transform: scale(1.07);
  box-shadow: 0 4px 12px rgba(254, 198, 228, 0.3);
}


.product-details {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.title {
  font-size: 1.5rem;
  font-weight: 800;
  color: rgb(245, 245, 245);
  margin-bottom: 8px;
  letter-spacing: 0.5px;
}

.price {
  font-size: 2rem;
  font-weight: 900;
  color: rgb(254, 198, 228);
  margin-bottom: 18px;
}

.badge-status {
  display: inline-block;
  padding: 4px 14px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 500;
  margin-bottom: 12px;
  background: rgb(254, 198, 228);
  letter-spacing: 0.5px;
  border: 1px solid #444;
}

.badge-available {

  color: rgb(0, 0, 0);
  border: 1px solid rgb(254, 198, 228);
}

.badge-unavailable {
  color: rgb(0, 0, 0);
  border: 1px solid rgb(254, 198, 228);
}

.product-info-grid {
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 18px;
  margin-top: 18px;

  border-radius: 12px;
}

.info-item {
  display: flex;
  align-items: center;
  font-size: 15px;
  color: rgb(245, 245, 245);
}

.info-label {
  font-weight: 500;
  color: rgb(254, 198, 228);
  min-width: 80px;
}

.info-value {
  font-weight: 500;
  color: rgb(245, 245, 245);
}

.rating-item {
  display: flex;
  align-items: center;

}

.star-icon {
  color: rgb(254, 198, 228);
  font-size: 16px;
}

hr {
  border: none;
  border-top: 1px solid #222;
  margin: 24px 0;
}

.detail-tabs {
  display: flex;
  border-bottom: 1.5px solid #222;
  margin-bottom: 18px;
  gap: 0;
}

.tab {
  padding: 10px 28px;
  font-size: 1.08rem;
  font-weight: 600;
  color: #888;
  background: none;
  border: none;
  border-bottom: 3px solid transparent;
  cursor: pointer;
  transition: color 0.2s, border 0.2s;
}

.tab.active {
  color: rgb(254, 198, 228);
  border-bottom: 3px solid rgb(254, 198, 228);
  background: none;
}

.detail-content {
  font-size: 1rem;
  color: rgb(245, 245, 245);
  margin-top: 10px;
  margin-bottom: 0;
  line-height: 1.7;
}

.detail-content strong {
  color: rgb(254, 198, 228);
}

/* Card Kanan - Atur Jumlah dan Catatan */
.right-card {
  flex: 0 0 340px;

  border-radius: 16px;
  padding: 24px;
  box-shadow: 0 4px 32px rgba(0,0,0,0.3);
  height: fit-content;
  position: sticky;
  top: 32px;
  border: 1px solid #222;
}

.card-title {
  font-size: 1.2rem;
  font-weight: 800;
  color: rgb(254, 198, 228);
  margin-bottom: 20px;
  text-align: left;
}

.product-info {
  display: flex;
  gap: 14px;
  align-items: center;
  margin-bottom: 20px;
  padding: 12px;
  background:rgb(0, 0, 0);
  border-radius: 12px;
  border: 1px solid #222;
}

.product-info img {
  width: 54px;
  height: 54px;
  border-radius: 10px;
  object-fit: cover;
  box-shadow: 0 1px 4px rgba(0,0,0,0.4);
  border: 1px solid #222;
}

.product-name {
  font-weight: 600;
  font-size: 1.08rem;
  color: rgb(245, 245, 245);
}

.quantity-section {
  margin-bottom: 20px;
}

.quantity-label {
  font-size: 14px;
  font-weight: 600;
  color: rgb(254, 198, 228);
  margin-bottom: 8px;
  display: block;
}

.quantity-stock {
  display: flex;
  align-items: center;
  gap: 18px;
}

.quantity-control {
  display: flex;
  align-items: center;
  border: 1.5px solid #222;
  border-radius: 10px;
  overflow: hidden;
  width: 104px;
  height: 40px;
}

.quantity-control button {
  border: none;
  background: none;
  font-size: 22px;
  color: rgb(254, 198, 228);
  font-weight: 700;
  width: 34px;
  height: 40px;
  cursor: pointer;
  user-select: none;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: background 0.15s;
}

.quantity-control button:hover {
  background: rgba(254, 198, 228, 0.1);
}

.quantity-control button:disabled {
  color: #555;
  cursor: default;
}

.quantity-control input {
  width: 36px;
  height: 40px;
  border: none;
  text-align: center;
  font-size: 17px;
  font-weight: 700;
  color: rgb(245, 245, 245);
  outline: none;
  background: none;
  user-select: none;
}

.stock-text {
  font-weight: 600;
  font-size: 14px;
  color: rgb(245, 245, 245);
}

.notes-section {
  margin-bottom: 20px;
}

.notes-label {
  font-size: 14px;
  font-weight: 600;
  color: rgb(254, 198, 228);
  margin-bottom: 8px;
  display: block;
}

.notes-input {
  width: 100%;
  min-height: 80px;
  padding: 12px;
  border: 1.5px solid #222;
  border-radius: 10px;
  font-size: 14px;
  color: rgb(245, 245, 245);
  background:rgb(0, 0, 0);
  resize: vertical;
  font-family: inherit;
}

.notes-input:focus {
  outline: none;
  border-color: rgb(254, 198, 228);
  box-shadow: 0 0 0 2px rgba(254, 198, 228, 0.2);
}

.notes-input::placeholder {
  color: #888;
}

.subtotal-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  border-radius: 10px;
  color: rgb(245, 245, 245);
  font-size: 1rem; /* Ukuran teks kecil untuk label "Subtotal" */
}

.subtotal-row strong {
  color: rgb(254, 198, 228);
  font-weight: bold;
  font-size: 1.5rem; /* Lebih besar dari label */
}

.btn-primary {
  background: rgb(254, 198, 228);
  border: none;
  border-radius: 10px;
  color: #111;
  font-weight: 700;
  font-size: 1.08rem;
  padding: 13px 0;
  cursor: pointer;
  width: 100%;
  margin-bottom: 10px;
  box-shadow: 0 2px 8px rgba(254, 198, 228, 0.3);
  transition: all 0.2s;
}

.btn-primary:hover {
  background: rgba(254, 198, 228, 0.9);
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(254, 198, 228, 0.4);
}

.btn-secondary {
  background: transparent;
  border: 1.5px solid rgb(254, 198, 228);
  border-radius: 10px;
  color: rgb(254, 198, 228);
  font-weight: 700;
  font-size: 1.08rem;
  padding: 13px 0;
  cursor: pointer;
  width: 100%;
  margin-bottom: 10px;
  transition: all 0.2s;
}

.btn-secondary:hover {
  background: rgba(0, 0, 0, 0.1);
  transform: translateY(-1px);
}

.alert-info {
  background: rgba(0, 0, 0, 0.1);
  color: rgb(254, 198, 228);
  border-radius: 6px;
  padding: 10px 14px;
  font-size: 12px;
  margin-top: 8px;
  border: 1px solid rgba(254, 198, 228, 0.3);
}

.alert-info a {
  color: rgb(254, 198, 228);
  font-weight: bold;
  text-decoration: underline;
}

.cart-animation {
  position: fixed;
  width: 50px;
  height: 50px;
  background: rgb(254, 198, 228);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #111;
  font-size: 20px;
  opacity: 0;
  pointer-events: none;
  z-index: 1000;
  transition: none;
}

@media (max-width: 1200px) {
  .container {
    max-width: 100vw;
    margin: 16px;
    padding: 16px;
  }
  .main-content {
    gap: 16px;
  }
  .right-card {
    flex: 0 0 300px;
  }
}

@media (max-width: 900px) {
  .main-content {
    flex-direction: column;
    gap: 20px;
  }
  .left-card {
    flex-direction: column;
  }
  .image-section {
    flex: none;
    max-width: 100%;
  }
  .right-card {
    flex: none;
    position: static;
  }
}

@media (max-width: 600px) {
  .container {
    margin: 8px;
    padding: 8px;
  }
  .left-card, .right-card {
    padding: 16px;
    border-radius: 12px;
  }
  .image-carousel {
    height: 250px;
  }
  .thumbnail {
    width: 50px;
    height: 50px;
  }
}

/* Review Images Styling */
.feedback-images {
  margin-top: 15px;
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.feedback-images img {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
  border: 1px solid #333;
  transition: all 0.3s ease;
}

.feedback-images img:hover {
  transform: scale(1.05);
  border-color: rgb(254, 198, 228);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.feedback-images a {
  display: block;
  position: relative;
}

.feedback-images a::after {
  content: '🔍';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  opacity: 0;
  transition: opacity 0.3s ease;
  font-size: 20px;
  background-color: rgba(0, 0, 0, 0.5);
  border-radius: 50%;
  width: 30px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.feedback-images a:hover::after {
  opacity: 1;
}

.review-image {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
  border: 1px solid #333;
  transition: all 0.3s ease;
}

.review-image:hover {
  transform: scale(1.05);
  border-color: rgb(254, 198, 228);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.review-image-link {
  display: block;
  position: relative;
  overflow: hidden;
  border-radius: 8px;
}
</style>

<div class="container" role="main">

@if(session('success'))
<div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); color: #22c55e; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
  {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
  {{ session('error') }}
</div>
@endif

<nav aria-label="Breadcrumb" style="font-size:1rem; font-family:Arial, sans-serif; margin-bottom:12px;">
  <ol style="list-style:none; padding:0; margin:0; display:flex; flex-wrap:nowrap; align-items:center; gap:6px; color:#fff;">
    <li><a href="/" style="color:rgb(245, 245, 245); text-decoration:none; font-weight:normal;">Home</a></li>
    <li style="color:#888;">&gt;</li>
    <li><a href="/bakeries" style="color:#fff; text-decoration:none; font-weight:normal;">Bakeries</a></li>
    <li style="color:#888;">&gt;</li>
    <li style="font-weight:normal;">{{ $menu->kategori }}</li>
    <li style="color:#888;">&gt;</li>
    <li style="color:#fec6e4; font-weight:normal;">{{ $menu->name }}</li>
  </ol>
</nav>




  <div class="main-content">
    
    <!-- Card Kiri: Foto dan Atribut Produk -->
    <div class="left-card">
      
      <!-- Bagian Gambar -->
      <section aria-label="Product images" class="image-section">
  <div class="image-carousel" id="product-carousel">
    @if($menu->images)
      <div class="carousel-inner">
        @php
          $images = json_decode($menu->images);
          $displayImages = is_array($images) ? $images : [];
        @endphp
        @if(count($displayImages) > 0)
          @foreach($displayImages as $index => $imagePath)
            <div class="carousel-item" data-index="{{ $index }}">
              <img src="{{ asset('storage/'.$imagePath) }}" alt="{{ $menu->name }} image {{ $index + 1 }}">
            </div>
          @endforeach
        @else
          <div class="carousel-item">
            <img src="https://via.placeholder.com/400x400?text=No+Image" alt="No image">
          </div>
        @endif
      </div>
      @if(count($displayImages) > 1)
        <button class="carousel-control carousel-control-prev" onclick="prevSlide()">&#10094;</button>
        <button class="carousel-control carousel-control-next" onclick="nextSlide()">&#10095;</button>
      @endif
    @elseif($menu->image)
      <img class="main-image" src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}">
    @else
      <img class="main-image" src="https://via.placeholder.com/400x400?text=No+Image" alt="No image">
    @endif
  </div>

  <!-- Thumbnail Gallery -->
  @if($menu->images)
    @php
      $images = json_decode($menu->images);
      $displayImages = is_array($images) ? $images : [];
      $thumbCount = count($displayImages);
      $maxVisibleThumbs = 5;
      $showScroll = $thumbCount > $maxVisibleThumbs;
      $visibleThumbs = $showScroll ? $maxVisibleThumbs : $thumbCount;
    @endphp
    @if($thumbCount > 0)
      <div 
        class="thumbnail-container {{ $showScroll ? 'scrollable' : '' }}" 
        id="thumbnail-gallery"
        style="--visible-thumbs: {{ $visibleThumbs }}"
      >
        @foreach($displayImages as $index => $imagePath)
          <img 
            src="{{ asset('storage/'.$imagePath) }}" 
            alt="Thumbnail {{ $index + 1 }}" 
            class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
            data-index="{{ $index }}"
            onclick="showSlide({{ $index }})"
          >
        @endforeach
      </div>
    @endif
  @endif
</section>


      <!-- Bagian Detail Produk -->
      <section aria-label="Product details" class="product-details">
        <h1 class="title">{{ $menu->name }}</h1>

        <div class="price">Rp. {{ number_format($menu->price, 0, ',', '.') }}</div>

        <div>
          @if(isset($menu->available))
            <span class="badge-status {{ $menu->available ? 'badge-available' : 'badge-unavailable' }}">
              {{ $menu->available ? 'Tersedia' : 'Tidak Tersedia' }}
            </span>
          @endif
        </div>

        <!-- Info Grid Vertikal -->
        

  

        <nav class="detail-tabs" role="tablist">
          <button 
            class="tab active" 
            id="tab-detail" 
            role="tab" 
            aria-controls="tabpanel-detail" 
            aria-selected="true"
            tabindex="0"
          >
            Detail
          </button>
        </nav>

    <div class="product-info-grid">
  <div class="info-item">
    <span class="info-label">Kategori:</span>
    <span class="info-value">{{ $menu->kategori }}</span>
  </div>
  <div class="info-item">
    <span class="info-label">Stok:</span>
    <span class="info-value">{{ $menu->stok }}</span>
  </div>
  <div class="info-item">
    <span class="info-label">Terjual:</span>
    <span class="info-value">{{ $menu->terjual ?? 0 }}</span>
  </div>
  <div class="info-item rating-item">
    <span class="info-label">Rating:</span>
    <span class="star-icon">★</span>
    <span class="info-value">
      {{ $menu->reviews->count() > 0 ? number_format($menu->reviews->avg('rating'), 1) : '0.0' }}
    </span>
    <span style="color: #888;">({{ $menu->reviews->count() }} rating)</span>
  </div>
</div>

        <section 
          class="detail-content" 
          id="tabpanel-detail" 
          role="tabpanel" 
          aria-labelledby="tab-detail"
          tabindex="0"
        >
          <p>{{ $menu->description }}</p>
        </section>
      </section>
    </div>

    <!-- Card Kanan: Atur Jumlah dan Catatan -->
    <div class="right-card">
      <h2 class="card-title">Atur Jumlah dan Catatan</h2>

      <div class="product-info">
        @if($menu->images)
          @php
            $images = json_decode($menu->images);
            $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
          @endphp
          <img 
            alt="Thumbnail of {{ $menu->name }}" 
            height="50" 
            src="{{ $firstImage ? asset('storage/'.$firstImage) : 'https://via.placeholder.com/50?text=No+Image' }}" 
            width="50"
          />
        @elseif($menu->image)
          <img 
            alt="Thumbnail of {{ $menu->name }}" 
            height="50" 
            src="{{ asset('storage/'.$menu->image) }}" 
            width="50"
          />
        @else
          <img 
            alt="No image" 
            height="50" 
            src="https://via.placeholder.com/50?text=No+Image" 
            width="50"
          />
        @endif
        <span class="product-name">{{ $menu->name }}</span>
      </div>

      <div class="quantity-section">
        <label class="quantity-label">Jumlah</label>
        <div class="quantity-stock">
          <div class="quantity-control">
            <button id="decrease-qty" type="button" onclick="updateQuantity(-1)">-</button>
            <input id="quantity" readonly type="text" value="1" />
            <button id="increase-qty" type="button" onclick="updateQuantity(1)">+</button>
          </div>
          <span class="stock-text">Stok: <strong>{{ $menu->stok }}</strong></span>
        </div>
      </div>

      <div class="notes-section">
        <label class="notes-label" for="order-notes">Catatan Pesanan</label>
        <textarea 
          id="order-notes" 
          class="notes-input" 
          placeholder="Tambahkan catatan untuk pesanan Anda (opsional)..."
        ></textarea>
      </div>

      <div class="subtotal-row">
  <span>Subtotal</span>
  <strong id="subtotal">
    <span class="rp">Rp</span>{{ number_format($menu->price, 0, ',', '.') }}
  </strong>
</div>



      <form id="add-to-cart-form" action="{{ route('carts.store') }}" method="POST">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
        <input type="hidden" name="quantity" id="cart-quantity" value="1">
        <input type="hidden" name="notes" id="cart-notes" value="">
        <button id="add-to-cart-btn" class="btn-primary" type="button" onclick="addToCart()">+ Keranjang</button>
      </form>
      <button class="btn-secondary" type="button" onclick="buyNow()">Beli Langsung</button>
      
      @if(!$isLoggedIn)
      <div class="alert-info">
        <i class="fas fa-info-circle"></i> Anda perlu <a href="{{ route('login') }}">login</a> untuk menambahkan produk ke keranjang atau melakukan pembelian.
      </div>
      @endif
    </div>
  </div>
  
  <!-- Cart Animation Element -->
  <div id="cart-animation" class="cart-animation">
    <i class="fas fa-shopping-cart"></i>
  </div>
</div>



<script>
  // Carousel functionality
  let currentIndex = 0;
  const carousel = document.getElementById('product-carousel');
  const inner = carousel ? carousel.querySelector('.carousel-inner') : null;
  const items = inner ? inner.querySelectorAll('.carousel-item') : [];
  const totalItems = items.length;
  const thumbnails = document.querySelectorAll('.thumbnail');
  
  function updateCartCount(count) {
    const navElement = document.querySelector('nav');
    if (navElement && window.Alpine) {
      Alpine.evaluate(navElement, `cartCount = ${count}`);
    }
  }
          
  function showSlide(index) {
    if (!inner || totalItems === 0) return;
    
    if (index >= totalItems) {
      currentIndex = 0;
    } else if (index < 0) {
      currentIndex = totalItems - 1;
    } else {
      currentIndex = index;
    }

    inner.style.transform = `translateX(-${currentIndex * 100}%)`;
    
    thumbnails.forEach((thumb, i) => {
      if (i === currentIndex) {
        thumb.classList.add('active');
      } else {
        thumb.classList.remove('active');
      }
    });
  }
  
  function nextSlide() {
    showSlide(currentIndex + 1);
  }
  
  function prevSlide() {
    showSlide(currentIndex - 1);
  }
  
  if (totalItems > 1) {
    setInterval(nextSlide, 5000);
  }
  
  // Quantity control
  const quantityInput = document.getElementById('quantity');
  const cartQuantityInput = document.getElementById('cart-quantity');
  const cartNotesInput = document.getElementById('cart-notes');
  const notesTextarea = document.getElementById('order-notes');
  const decreaseBtn = document.getElementById('decrease-qty');
  const increaseBtn = document.getElementById('increase-qty');
  const subtotalElement = document.getElementById('subtotal');
  const maxStock = {{ $menu->stok }};
  const price = {{ $menu->price }};
  
  function updateQuantity(change) {
    let currentQty = parseInt(quantityInput.value);
    let newQty = currentQty + change;
    
    if (newQty < 1) newQty = 1;
    if (newQty > maxStock) newQty = maxStock;
    
    quantityInput.value = newQty;
    cartQuantityInput.value = newQty;
    
    const subtotal = price * newQty;
    subtotalElement.textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(subtotal);
    
    decreaseBtn.disabled = newQty <= 1;
    increaseBtn.disabled = newQty >= maxStock;
  }
  
  // Update notes when textarea changes
  notesTextarea.addEventListener('input', function() {
    cartNotesInput.value = this.value;
  });
  
  decreaseBtn.disabled = true;
  increaseBtn.disabled = maxStock <= 1;
  
  function addToCart() {
    const isLoggedIn = {{ $isLoggedIn ? 'true' : 'false' }};
    
    if (!isLoggedIn) {
      window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.href);
      return;
    }
    
    const button = document.getElementById('add-to-cart-btn');
    const animation = document.getElementById('cart-animation');
    const form = document.getElementById('add-to-cart-form');
    
    const buttonRect = button.getBoundingClientRect();
    const buttonX = buttonRect.left + buttonRect.width / 2;
    const buttonY = buttonRect.top + buttonRect.height / 2;
    
    const cartIconX = window.innerWidth - 20;
    const cartIconY = 20;
    
    animation.style.left = `${buttonX - 25}px`;
    animation.style.top = `${buttonY - 25}px`;
    animation.style.opacity = '1';

    const formData = new FormData(form);
    fetch(form.action, {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        if (data.cartCount !== undefined) {
          updateCartCount(data.cartCount);
        } else {
          fetch("{{ route('cart.count') }}")
            .then(response => response.json())
            .then(countData => {
              updateCartCount(countData.cartCount);
            });
        }

        setTimeout(() => {
          animation.style.transition = 'all 0.8s cubic-bezier(0.2, 1, 0.3, 1)';
          animation.style.left = `${cartIconX - 25}px`;
          animation.style.top = `${cartIconY - 25}px`;
          animation.style.transform = 'scale(0.5)';
        }, 10);

        setTimeout(() => {
          animation.style.opacity = '0';
          animation.style.transform = 'scale(0.2)';
          alert('Produk berhasil ditambahkan ke keranjang!');
        }, 800);
      } else {
        alert(data.message || 'Gagal menambahkan produk ke keranjang.');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat menambahkan produk ke keranjang.');
    });
  }
  
  function buyNow() {
    const isLoggedIn = {{ $isLoggedIn ? 'true' : 'false' }};
    
    if (!isLoggedIn) {
      window.location.href = "{{ route('login') }}?redirect=" + encodeURIComponent(window.location.href);
      return;
    }
    
    // Ambil data dari form
    const menuId = document.querySelector('input[name="menu_id"]').value;
    const quantity = document.getElementById('cart-quantity').value;
    const notes = document.getElementById('cart-notes').value;
    
    // Buat form baru untuk langsung checkout
    const checkoutForm = document.createElement('form');
    checkoutForm.method = 'POST';
    checkoutForm.action = "{{ route('orders.store') }}";
    checkoutForm.style.display = 'none';
    
    // Tambahkan CSRF token
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
    checkoutForm.appendChild(csrfToken);
    
    // Tambahkan data menu yang akan dibeli
    const menuIdInput = document.createElement('input');
    menuIdInput.type = 'hidden';
    menuIdInput.name = 'direct_checkout';
    menuIdInput.value = 'true';
    checkoutForm.appendChild(menuIdInput);
    
    const menuIdInput2 = document.createElement('input');
    menuIdInput2.type = 'hidden';
    menuIdInput2.name = 'menu_id';
    menuIdInput2.value = menuId;
    checkoutForm.appendChild(menuIdInput2);
    
    const quantityInput = document.createElement('input');
    quantityInput.type = 'hidden';
    quantityInput.name = 'quantity';
    quantityInput.value = quantity;
    checkoutForm.appendChild(quantityInput);
    
    const notesInput = document.createElement('input');
    notesInput.type = 'hidden';
    notesInput.name = 'notes';
    notesInput.value = notes;
    checkoutForm.appendChild(notesInput);
    
    // Tambahkan form ke body dan submit
    document.body.appendChild(checkoutForm);
    checkoutForm.submit();
  }
</script>

<!-- Review Section - Black & Pink Theme -->
<div class="review-black-pink-style" style="max-width: 1200px; margin: 32px auto; padding: 0 24px;">
  @php
    // Ambil review untuk menu ini
    $menuReviews = \App\Models\Review::where('menu_id', $menu->id)
      ->with('user')
      ->orderBy('created_at', 'desc')
      ->take(5)
      ->get();
    
    $totalReviews = \App\Models\Review::where('menu_id', $menu->id)->count();
    $averageRating = $totalReviews > 0 ? \App\Models\Review::where('menu_id', $menu->id)->avg('rating') : 0;
    
    // Hitung distribusi rating
    $ratingCounts = [
      5 => \App\Models\Review::where('menu_id', $menu->id)->where('rating', 5)->count(),
      4 => \App\Models\Review::where('menu_id', $menu->id)->where('rating', 4)->count(),
      3 => \App\Models\Review::where('menu_id', $menu->id)->where('rating', 3)->count(),
      2 => \App\Models\Review::where('menu_id', $menu->id)->where('rating', 2)->count(),
      1 => \App\Models\Review::where('menu_id', $menu->id)->where('rating', 1)->count(),
    ];
    
    // Pink color
    $pinkPrimary = 'rgb(254, 198, 228)';
  @endphp

  <!-- Black & Pink Style Review Section -->
  <div style="background: #000000; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); overflow: hidden; margin-bottom: 24px; border: 1px solid #222;">
    <!-- Header Section -->
    <div style="padding: 16px 24px; border-bottom: 1px solid #333; display: flex; justify-content: space-between; align-items: center;">
      <h2 style="font-size: 20px; font-weight: 700; color: {{ $pinkPrimary }}; margin: 0;">Ulasan Pembeli</h2>
    </div>
    
    <!-- Rating Overview -->
    <div style="padding: 24px; display: flex; border-bottom: 8px solid #222; background: #000000;">
      <!-- Left: Rating Score -->
      <div style="flex: 0 0 180px; border-right: 1px solid #333; padding-right: 24px;">
        <div style="text-align: center;">
          <div style="font-size: 48px; font-weight: 700; color: {{ $pinkPrimary }}; line-height: 1.2;">{{ number_format($averageRating, 1) }}</div>
          <div style="margin: 8px 0;">
            @for($i = 1; $i <= 5; $i++)
              <span style="color: {{ $i <= round($averageRating) ? $pinkPrimary : '#444' }}; font-size: 20px;">★</span>
            @endfor
          </div>
          <div style="color: #aaa; font-size: 14px;">{{ $totalReviews }} Ulasan</div>
        </div>
      </div>
      
      <!-- Right: Rating Distribution -->
      <div style="flex: 1; padding-left: 24px;">
        @for($i = 5; $i >= 1; $i--)
          @php
            $percentage = $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews) * 100 : 0;
          @endphp
          <div style="display: flex; align-items: center; margin-bottom: {{ $i > 1 ? '12px' : '0' }};">
            <div style="flex: 0 0 30px; font-size: 14px; color: #aaa;">{{ $i }}</div>
            <div style="margin: 0 8px;">
              <span style="color: {{ $pinkPrimary }}; font-size: 14px;">★</span>
            </div>
            <div style="flex: 1; height: 8px; background: #333; border-radius: 4px; overflow: hidden;">
              <div style="height: 100%; width: {{ $percentage }}%; background: {{ $pinkPrimary }};"></div>
            </div>
            <div style="margin-left: 8px; font-size: 14px; color: #aaa; width: 40px; text-align: right;">{{ $ratingCounts[$i] }}</div>
          </div>
        @endfor
      </div>
    </div>
    
    <!-- Review List -->
    <div>
      @forelse($menuReviews as $review)
        <div style="padding: 20px 24px; border-bottom: 1px solid #333; transition: all 0.3s ease; background: #000000;">
          <!-- Review Header -->
          <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
            <div style="display: flex; align-items: center;">
              <div style="margin-right: 16px;">
                <img src="{{ $review->user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=333&color=fec6e4' }}" 
                     alt="{{ $review->user->name }}" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid {{ $pinkPrimary }};">
              </div>
              <div>
                <div style="font-weight: 600; color: #fff; font-size: 15px;">{{ $review->user->name }}</div>
                <div style="color: #aaa; font-size: 13px;">{{ $review->created_at->format('d M Y') }}</div>
              </div>
            </div>
            <div style="background: rgba(254, 198, 228, 0.1); padding: 6px 12px; border-radius: 20px;">
              @for($i = 1; $i <= 5; $i++)
                <span style="color: {{ $i <= $review->rating ? $pinkPrimary : '#444' }}; font-size: 16px;">★</span>
              @endfor
            </div>
          </div>
          
          <!-- Review Content -->
          <div style="color: #ddd; font-size: 15px; line-height: 1.6; margin-bottom: 16px; padding: 0 4px;">
            {{ $review->comment }}
          </div>
          
          <!-- Review Images -->
          @if($review->images && count($review->images) > 0)
          <div class="feedback-images">
            @foreach($review->images as $image)
              <a href="{{ asset('storage/' . $image) }}" target="_blank" class="review-image-link" onclick="event.preventDefault(); openImageModal('{{ asset('storage/' . $image) }}')">
                <img src="{{ asset('storage/' . $image) }}" alt="Review Image" class="review-image">
              </a>
            @endforeach
          </div>
          @endif
          
          <!-- Review Footer -->
          <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px solid #333;">
            <div style="color: #aaa; font-size: 13px;">
              Order ID: {{ substr($review->order->order_code ?? 'ORD-XXXXXXXX', 0, 8) }}...
            </div>
            <div style="display: flex; align-items: center;">
              <button style="background: none; border: none; color: #aaa; font-size: 14px; display: flex; align-items: center; cursor: pointer; margin-right: 16px; transition: all 0.2s ease; padding: 6px 10px; border-radius: 20px; hover:background: rgba(254, 198, 228, 0.1);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                  <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                </svg>
                Membantu
              </button>
              <button style="background: none; border: none; color: #aaa; font-size: 14px; display: flex; align-items: center; cursor: pointer; transition: all 0.2s ease; padding: 6px 10px; border-radius: 20px; hover:background: rgba(254, 198, 228, 0.1);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                  <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                </svg>
                Tidak Membantu
              </button>
            </div>
          </div>
        </div>
      @empty
        <div style="padding: 48px 24px; text-align: center; background: #000000;">
          <div style="margin-bottom: 20px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="{{ $pinkPrimary }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.5;">
              <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
            </svg>
          </div>
          <div style="color: #aaa; font-size: 16px; margin-bottom: 24px;">Belum ada ulasan untuk produk ini</div>
          @auth
            <a href="{{ route('customer.reviews', ['menu_id' => $menu->id]) }}" style="display: inline-block; background: {{ $pinkPrimary }}; color: #111; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s ease;">Beri Ulasan</a>
          @else
            <a href="{{ route('login') }}?redirect={{ urlencode(route('customer.reviews', ['menu_id' => $menu->id])) }}" style="display: inline-block; background: {{ $pinkPrimary }}; color: #111; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.3s ease;">Login untuk Beri Ulasan</a>
          @endauth
        </div>
      @endforelse
    </div>
    
    <!-- Footer - See All Reviews -->
    @if($totalReviews > 5)
      <div style="padding: 20px 24px; text-align: center; border-top: 1px solid #333; background: #000000;">
        <a href="{{ route('customer.reviews', ['menu_id' => $menu->id]) }}" style="display: inline-block; background: transparent; color: {{ $pinkPrimary }}; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; border: 1px solid {{ $pinkPrimary }}; transition: all 0.3s ease;">Lihat Semua Ulasan</a>
      </div>
    @endif
  </div>
  
  <!-- Write Review Button (Fixed at Bottom on Mobile) -->
  <div class="mobile-review-button" style="position: fixed; bottom: 16px; left: 0; right: 0; text-align: center; z-index: 100; padding: 0 16px; display: none;">
    @auth
      <a href="{{ route('customer.reviews', ['menu_id' => $menu->id]) }}" style="display: inline-block; background: {{ $pinkPrimary }}; color: #111; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; box-shadow: 0 4px 12px rgba(254, 198, 228, 0.3); width: 100%; max-width: 400px; transition: all 0.3s ease;">Beri Ulasan</a>
    @else
      <a href="{{ route('login') }}?redirect={{ urlencode(route('customer.reviews', ['menu_id' => $menu->id])) }}" style="display: inline-block; background: {{ $pinkPrimary }}; color: #111; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; box-shadow: 0 4px 12px rgba(254, 198, 228, 0.3); width: 100%; max-width: 400px; transition: all 0.3s ease;">Login untuk Beri Ulasan</a>
    @endauth
  </div>
</div>

<style>
  @media (max-width: 768px) {
    .mobile-review-button {
      display: block;
    }
    
    .review-black-pink-style {
      padding: 0 12px;
    }
    
    /* Rating Overview responsive */
    .review-black-pink-style [style*="display: flex; border-bottom: 8px solid #222"] {
      flex-direction: column;
    }
    
    .review-black-pink-style [style*="flex: 0 0 180px; border-right: 1px solid #333"] {
      flex: 1 1 auto;
      border-right: none;
      border-bottom: 1px solid #333;
      padding-right: 0;
      padding-bottom: 20px;
      margin-bottom: 20px;
    }
    
    .review-black-pink-style [style*="flex: 1; padding-left: 24px"] {
      padding-left: 0;
    }
    
    /* Review item responsive */
    .review-black-pink-style [style*="display: flex; justify-content: space-between; margin-bottom: 16px"] {
      flex-direction: column;
      align-items: flex-start;
    }
    
    .review-black-pink-style [style*="background: rgba(254, 198, 228, 0.1); padding: 6px 12px; border-radius: 20px"] {
      margin-top: 12px;
      align-self: flex-start;
    }
    
    /* Review footer responsive */
    .review-black-pink-style [style*="display: flex; justify-content: space-between; align-items: center; padding-top: 12px"] {
      flex-direction: column;
      align-items: flex-start;
    }
    
    .review-black-pink-style [style*="display: flex; align-items: center;"] {
      margin-top: 12px;
    }
    
    /* Review images responsive */
    .feedback-images {
      gap: 8px;
    }
    
    .review-image {
      width: 70px;
      height: 70px;
    }
  }
  
  /* Hover effects */
  .review-black-pink-style a:hover {
    opacity: 0.8;
  }
  
  .review-black-pink-style button:hover {
    background: rgba(254, 198, 228, 0.1) !important;
    color: rgb(254, 198, 228) !important;
  }
</style>

<!-- Image Modal -->
<div id="imageModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.9); backdrop-filter: blur(5px);">
  <span class="close-modal" style="position: absolute; top: 15px; right: 35px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer; z-index: 1001;">&times;</span>
  <img id="modalImage" style="margin: auto; display: block; max-width: 90%; max-height: 90%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
</div>

<script>
  // Image Modal Functions
  function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    
    modal.style.display = "block";
    modalImg.src = imageSrc;
    
    // Prevent body scrolling when modal is open
    document.body.style.overflow = 'hidden';
  }
  
  // Close modal when clicking the X
  document.querySelector('.close-modal').addEventListener('click', function() {
    document.getElementById('imageModal').style.display = "none";
    document.body.style.overflow = 'auto';
  });
  
  // Close modal when clicking outside the image
  document.getElementById('imageModal').addEventListener('click', function(event) {
    if (event.target === this) {
      this.style.display = "none";
      document.body.style.overflow = 'auto';
    }
  });
</script>

@endsection