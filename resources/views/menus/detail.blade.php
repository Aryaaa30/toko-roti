@extends('layouts.app')

@section('content')
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Product Page
  </title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
   * {
    box-sizing: border-box;
  }
  body {
    margin: 0;
    background-color: #2b2b2b;
    font-family: 'Inter', sans-serif;
    color: #222;
  }
  a {
    text-decoration: none;
    color: #009245;
    font-weight: 500;
    font-size: 14px;
  }
  a:hover {
    text-decoration: underline;
  }
 .container {
  display: flex;
  gap: 20px;
  align-items: flex-start;
   padding-left: 130px;
   margin: 40px auto 0;
}
  .breadcrumb {
    display: flex;
    flex-wrap: wrap;
    font-size: 14px;
    line-height: 1.3;
    margin-bottom: 20px;
  }
  .breadcrumb a {
    margin-right: 4px;
  }
  .breadcrumb span.separator {
    margin-right: 4px;
    color: #666;
  }
  .breadcrumb .last {
    color: #222;
    font-weight: 400;
  }
  .main-content {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
  }
  .left-column {
    flex: 1 1 320px;
    max-width: 320px;
  }
  .main-image {
    width: 320px;
    height: 400px;
    border-radius: 8px;
    object-fit: cover;
    display: block;
  }
  .tooltip {
    position: absolute;
    background: rgba(0,0,0,0.75);
    color: #fff;
    font-size: 12px;
    padding: 3px 6px;
    border-radius: 3px;
    bottom: 10px;
    left: 10px;
    pointer-events: none;
    user-select: none;
  }
  .thumbnail-row {
    margin-top: 10px;
    display: flex;
    gap: 10px;
  }
  .thumbnail {
    width: 56px;
    height: 56px;
    border-radius: 6px;
    object-fit: cover;
    cursor: pointer;
    position: relative;
  }
  .thumbnail.play-button::after {
    content: "\f04b";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    position: absolute;
    font-size: 20px;
    color: #fff;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
  }
  .thumbnail-nav {
    width: 24px;
    height: 56px;
    background: #666;
    border-radius: 0 6px 6px 0;
    color: #fff;
    font-size: 18px;
    line-height: 56px;
    text-align: center;
    cursor: pointer;
    user-select: none;
  }
  .right-column {
    flex: 1 1 600px;
    max-width: 600px;
    display: flex;
    flex-direction: column;
  }
  .title {
    font-weight: 700;
    font-size: 18px;
    line-height: 1.2;
    margin: 0 0 6px 0;
    text-transform: uppercase;
  }
  .rating-row {
    font-size: 14px;
    color: #222;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
  }
  .rating-row span {
    color: #666;
  }
  .rating-row .star {
    color: #f7c948;
  }
  .price {
    font-weight: 700;
    font-size: 28px;
    margin-bottom: 20px;
  }
  hr {
    border: none;
    border-top: 1px solid #ddd;
    margin: 0 0 20px 0;
  }
  .option-group {
    margin-bottom: 20px;
  }
  .option-group strong {
    font-weight: 700;
    font-size: 14px;
  }
  .option-group .label-bold {
    font-weight: 600;
    color: #222;
  }
  .color-options, .size-options {
    margin-top: 8px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }
  .color-button, .size-button {
    border-radius: 8px;
    border: 1px solid #c4c9d9;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: #fff;
    color: #666;
    user-select: none;
  }
  .color-button img {
    width: 20px;
    height: 20px;
    border-radius: 3px;
    object-fit: cover;
  }
  .color-button.active, .size-button.active {
    border-color: #009245;
    color: #009245;
    font-weight: 600;
  }
  .size-button {
    justify-content: center;
    width: 40px;
    height: 40px;
    font-weight: 600;
  }
  .size-button.active {
    background: #e6f4ea;
  }
  .detail-tabs {
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    display: flex;
    gap: 30px;
    margin-bottom: 20px;
  }
  .tab {
    font-weight: 600;
    font-size: 14px;
    padding: 12px 0;
    cursor: pointer;
    color: #666;
    border-bottom: 3px solid transparent;
  }
  .tab.active {
    color: #009245;
    border-bottom-color: #009245;
  }
  .detail-content {
    font-size: 14px;
    line-height: 1.5;
    color: #222;
  }
  .detail-content strong {
    font-weight: 600;
  }
  .detail-content a {
    color: #009245;
    font-weight: 600;
  }
 .sidebar {
  width: 280px;
  border: 1px solid #c4c9d9;
  border-radius: 8px;
  padding: 15px 20px 20px;
  font-size: 14px;
  line-height: 1.3;
  color: #222;
  display: flex;
  flex-direction: column;
  gap: 15px;
}
  .sidebar strong {
    font-weight: 700;
    font-size: 15px;
  }
  .sidebar .product-info {
    display: flex;
    gap: 10px;
    align-items: center;
  }
  .sidebar .product-info img {
    width: 50px;
    height: 50px;
    border-radius: 6px;
    object-fit: cover;
  }
  .sidebar .product-name {
    font-weight: 500;
    font-size: 14px;
    color: #222;
  }
  .quantity-stock {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 5px;
  }
  .quantity-control {
    display: flex;
    align-items: center;
    border: 1px solid #c4c9d9;
    border-radius: 8px;
    overflow: hidden;
    width: 90px;
    height: 36px;
  }
  .quantity-control button {
    border: none;
    background: none;
    font-size: 20px;
    color: #009245;
    font-weight: 700;
    width: 28px;
    height: 36px;
    cursor: pointer;
    user-select: none;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .quantity-control button:disabled {
    color: #ccc;
    cursor: default;
  }
  .quantity-control input {
    width: 34px;
    height: 36px;
    border: none;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    color: #222;
    outline: none;
    user-select: none;
  }
  .stock-text {
    font-weight: 700;
    font-size: 14px;
  }
  .subtotal-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    margin-top: 10px;
    margin-bottom: 15px;
  }
  .subtotal-row strong {
    font-weight: 700;
    font-size: 16px;
  }
  .btn-primary {
    background-color: #009245;
    border: none;
    border-radius: 8px;
    color: #fff;
    font-weight: 700;
    font-size: 16px;
    padding: 12px 0;
    cursor: pointer;
    width: 100%;
    margin-bottom: 10px;
  }
  .btn-primary:hover {
    background-color: #007a33;
  }
  .btn-secondary {
    background: none;
    border: 1px solid #009245;
    border-radius: 8px;
    color: #009245;
    font-weight: 700;
    font-size: 16px;
    padding: 12px 0;
    cursor: pointer;
    width: 100%;
    margin-bottom: 10px;
  }
  .btn-secondary:hover {
    background-color: #e6f4ea;
  }
  .sidebar-footer {
    display: flex;
    justify-content: space-between;
    font-weight: 700;
    font-size: 14px;
    color: #222;
  }
  .sidebar-footer > div {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    user-select: none;
  }
  .sidebar-footer > div:not(:last-child) {
    border-right: 1px solid #ddd;
    padding-right: 10px;
  }
  .sidebar-footer i {
    font-size: 16px;
  }
  @media (max-width: 1024px) {
    .main-content {
      flex-wrap: wrap;
    }
    .left-column, .right-column {
      max-width: 100%;
      flex: 1 1 100%;
    }
    .sidebar {
      width: 100%;
      margin-top: 30px;
    }
  }
  @media (max-width: 480px) {
    .breadcrumb {
      font-size: 12px;
    }
    .title {
      font-size: 16px;
    }
    .price {
      font-size: 22px;
    }
    .color-button, .size-button {
      font-size: 12px;
      padding: 5px 10px;
    }
    .size-button {
      width: 36px;
      height: 36px;
    }
    .btn-primary, .btn-secondary {
      font-size: 14px;
      padding: 10px 0;
    }
    .sidebar {
      padding: 15px 15px 20px;
      font-size: 13px;
    }
    .sidebar-footer {
      font-size: 13px;
    }
  }
  </style>
 </head>
 <body>

  <div class="container" role="main">
  <div class="main-content">
    <!-- Kiri: Gambar Produk -->
    <section aria-label="Product images" class="left-column">
      <div style="position:relative; display:inline-block; margin-bottom: 16px;">
        <img 
          alt="{{ $menu->name }}" 
          class="main-image" 
          height="400" 
          src="{{ $menu->image ? asset('storage/' . $menu->image) : 'https://via.placeholder.com/320x400?text=No+Image' }}" 
          width="320"
        />
        <div aria-hidden="true" class="tooltip">
          {{ strtoupper($menu->name) }}
        </div>
      </div>
    </section>

    <!-- Tengah: Detail Produk -->
    <section aria-label="Product details" class="right-column" style="padding: 20px;">
      <h1 class="title" style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">
        {{ $menu->name }}
      </h1>

      <div class="rating-row" style="font-size: 14px; margin-bottom: 8px; color: #333;">
        <span>Terjual <span style="color:#999;">{{ $menu->stok }}+</span></span>
        <span style="margin: 0 5px;">•</span>
        <span style="color: #f39c12;">★</span>
        <span>{{ number_format($menu->reviews->avg('rating'), 1) ?? '0.0' }}</span>
        <span style="color:#666;">({{ $menu->reviews->count() }} rating)</span>
      </div>

      <div class="price" style="font-size: 20px; font-weight: bold; color: #e74c3c;">
        Rp{{ number_format($menu->price, 0, ',', '.') }}
      </div>

      <hr/>

      <div class="option-group">
        <div>
          <strong>Pilih warna:</strong>
          <span class="label-bold">B.TERY NAVY</span>
        </div>
        <div class="color-options" role="list">
          <!-- Warna-warna -->
          @foreach (['NAVY', 'BLACK', 'HIJAU', 'MAROON', 'ABU MISTY'] as $color)
            <button 
              class="color-button{{ $loop->first ? ' active' : '' }}" 
              role="radio" 
              type="button"
              aria-checked="{{ $loop->first ? 'true' : 'false' }}"
              aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
              aria-label="B.TERY {{ $color }}"
            >
              <img 
                alt="Color swatch {{ strtolower($color) }}" 
                height="20" 
                src="https://storage.googleapis.com/a1aa/image/{{ strtolower($color) }}.jpg" 
                width="20"
              />
              B.TERY {{ $color }}
            </button>
          @endforeach
        </div>
      </div>

      <hr/>

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

      <section 
        class="detail-content" 
        id="tabpanel-detail" 
        role="tabpanel" 
        aria-labelledby="tab-detail"
        tabindex="0"
      >
        <p><strong>Kondisi:</strong> Baru</p>
        <p><strong>Min. Pemesanan:</strong> 1 Buah</p>
        <p>Etalase: <a href="#">Fashion Pria Dan Wanita Dewasa</a></p>
        <p>===========Detail Produk===========</p>
      </section>
    </section>
  </div>

  <!-- Kanan: Sidebar -->
  <aside class="sidebar" aria-label="Order summary and actions">
    <strong>Atur jumlah dan catatan</strong>

    <div class="product-info">
      <img 
        alt="Thumbnail of {{ $menu->name }}" 
        height="50" 
        src="{{ $menu->image ? asset('storage/'.$menu->image) : 'https://via.placeholder.com/50?text=No+Image' }}" 
        width="50"
      />
      <span class="product-name">{{ $menu->name }}, {{ $menu->size ?? 'Ukuran Standar' }}</span>
    </div>

    <div class="quantity-stock">
      <div 
        class="quantity-control" 
        role="spinbutton" 
        aria-valuemin="1" 
        aria-valuemax="{{ $menu->stok }}" 
        aria-valuenow="1"
      >
        <button aria-label="Decrease quantity" disabled type="button">-</button>
        <input readonly type="text" value="1" />
        <button aria-label="Increase quantity" type="button">+</button>
      </div>
      <span class="stock-text">Stok: <strong>{{ $menu->stok }}</strong></span>
    </div>

    <div class="subtotal-row">
      <span>Subtotal</span>
      <strong>Rp{{ number_format($menu->price, 0, ',', '.') }}</strong>
    </div>

    <button class="btn-primary" type="button">+ Keranjang</button>
    <button class="btn-secondary" type="button">Beli Langsung</button>

    <div class="sidebar-footer" role="group" aria-label="Chat, Wishlist and Share actions">
      <div role="button" tabindex="0" aria-pressed="false"><i class="far fa-comment"></i> Chat</div>
      <div role="button" tabindex="0" aria-pressed="false"><i class="far fa-heart"></i> Wishlist</div>
      <div role="button" tabindex="0" aria-pressed="false"><i class="fas fa-share-alt"></i> Share</div>
    </div>
  </aside>
</div>

</html>
@endsection
