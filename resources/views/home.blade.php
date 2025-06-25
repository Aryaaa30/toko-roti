@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
 <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Merriweather&display=swap" rel="stylesheet">
<style>
  section {
    background-color: #000;
  }
</style>

<style>
    :root {
        --primary-color: #FF6295;
        --secondary-color: #FFD0E9;
        --white-color: #FFFFFF;
        --black-color: #000000;
    }


</style>

<!-- Hero Section -->
<!-- Hero Section -->
<section class="hero-section" style="
    background-image: url('https://georgiannalane.com/wp-content/uploads/2022/12/IMG_6416-edit-blog.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
">
    <div style="position: relative; z-index: 2;">
        <h1 class="hero-title" style="font-size: 4rem; margin-bottom: 0.5rem;">Bake My Day</h1>
        <p class="hero-subtitle" style="font-size: 1.5rem; margin-bottom: 1.5rem;">Roti Segar Setiap Hari, Dibuat dengan Cinta</p>
        <div class="hero-cta">
            <a href="#menu" class="btn btn-secondary" style="padding: 0.75rem 1.5rem; font-size: 1.2rem;">Lihat Menu</a>
        </div>
    </div>
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1;"></div>
</section>



<section id="partners" class="py-12 bg-black text-white w-full">
  <div class="container mx-auto overflow-hidden px-4">
    <div class="logos" role="list" aria-label="Penghargaan">
      <!-- Duplicate slides for infinite effect -->
      <div class="logos-slide" aria-hidden="false">
        <span class="logo-text">Penghargaan Kue Terbaik Nasional</span>
<span class="logo-text">Penghargaan Inovasi Produk Bakery</span>
<span class="logo-text">Penghargaan Rasa Terunggul</span>
<span class="logo-text">Penghargaan Bakery Ramah Lingkungan</span>
<span class="logo-text">Penghargaan Pelayanan Pelanggan Terbaik</span>
<span class="logo-text">Penghargaan Bakery Tradisional Terbaik</span>
<span class="logo-text">Penghargaan Kreasi Roti Unik</span>
<span class="logo-text">Penghargaan Bakery Favorit Konsumen</span>
<span class="logo-text">Penghargaan Keunggulan Rasa dan Tekstur</span>
<span class="logo-text">Penghargaan Bakery Terinovatif Tahun Ini</span>

      </div>
      <div class="logos-slide" aria-hidden="true">
        <span class="logo-text">Penghargaan Kue Terbaik Nasional</span>
<span class="logo-text">Penghargaan Inovasi Produk Bakery</span>
<span class="logo-text">Penghargaan Rasa Terunggul</span>
<span class="logo-text">Penghargaan Bakery Ramah Lingkungan</span>
<span class="logo-text">Penghargaan Pelayanan Pelanggan Terbaik</span>
<span class="logo-text">Penghargaan Bakery Tradisional Terbaik</span>
<span class="logo-text">Penghargaan Kreasi Roti Unik</span>
<span class="logo-text">Penghargaan Bakery Favorit Konsumen</span>
<span class="logo-text">Penghargaan Keunggulan Rasa dan Tekstur</span>
<span class="logo-text">Penghargaan Bakery Terinovatif Tahun Ini</span>

      </div>
    </div>
  </div>
</section>

<style>
  /* Container full width */
  #partners {
    width: 100vw;
    overflow-x: hidden;
  }

  .container {
    max-width: 100%;
    padding-left: 0;
    padding-right: 0;
  }

  /* Infinite scrolling container */
  .logos {
    --gap: 0px;
    display: flex;
    gap: var(--gap);
    overflow: hidden;
    user-select: none;
  }

  .logos-slide {
    flex-shrink: 0;
    min-width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-around;
    animation: scroll 20s linear infinite;
  }

  .logos:hover .logos-slide {
    animation-play-state: paused;
  }

  @keyframes scroll {
    from {
      transform: translateX(0);
    }
    to {
      transform: translateX(calc(-100% - var(--gap)));
    }
  }

  /* Styling teks penghargaan */
  .logo-text {
    font-weight: 300;
    font-size: 1.25rem;
    margin: 0 24px;
    white-space: nowrap;
    filter: brightness(80%);
    transition: filter 0.3s ease;
    cursor: default;
  }

  .logo-text:hover {
    filter: brightness(100%);
    color: #f0f0f0;
  }

  /* Responsive design */
  @media (max-width: 768px) {
    .logos-slide {
      animation-duration: 25s;
    }
    .logo-text {
      font-size: 1rem;
      margin: 0 12px;
    }
  }
</style>




<!-- About Section -->

<section class="about-section section" id="about" style="background-color: #000; color: rgb(245, 245, 245); padding: 40px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div class="about-grid" style="display: flex; flex-wrap: wrap; gap: 40px; align-items: center;">
            <div class="about-content" style="flex: 1 1 400px; min-width: 280px;">
                <h2 style="font-weight: 500; font-size: 2.5rem; margin-bottom: 20px; color:rgb(254, 198, 228)">Tentang Kami</h2>
                <p style="font-weight: 300; font-size: 1.1rem; line-height: 1.6; margin-bottom: 15px;">
                    Sejak 2009, Toko Roti telah menjadi pilihan utama untuk roti segar dan berkualitas tinggi. Kami berkomitmen menggunakan bahan-bahan premium dan resep turun temurun yang telah terbukti menghasilkan roti dengan cita rasa yang tak terlupakan.
                </p>
                <p style="font-weight: 300; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                    Setiap hari, tim baker berpengalaman kami memanggang roti dengan penuh dedikasi, memastikan setiap produk yang sampai ke tangan Anda adalah yang terbaik.
                </p>
                <a href="#contact" class="btn btn-primary" style="display: inline-block; background-color: rgb(254, 198, 228); color: #000000; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: 600; transition: background-color 0.3s ease;">
                    Hubungi Kami
                </a>
            </div>
            <div class="stats-grid" style="flex: 1 1 300px; min-width: 280px; display: flex; justify-content: space-between; gap: 20px;">
                <div class="stat-item" style="text-align: center; flex: 1;">
                    <div class="stat-number" style="font-size: 2.5rem; font-weight: 500; margin-bottom: 8px; color: rgb(254, 198, 228)">16+</div>
                    <div class="stat-label" style="font-weight: 300; font-size: 1rem;">Tahun Berpengalaman</div>
                </div>
                <div class="stat-item" style="text-align: center; flex: 1;">
                    <div class="stat-number" style="font-size: 2.5rem; font-weight: 500; margin-bottom: 8px; color: rgb(254, 198, 228)">50+</div>
                    <div class="stat-label" style="font-weight: 300; font-size: 1rem;">Varian Roti</div>
                </div>
                <div class="stat-item" style="text-align: center; flex: 1;">
                    <div class="stat-number" style="font-size: 2.5rem; font-weight: 500; margin-bottom: 8px; color: rgb(254, 198, 228)">1000+</div>
                    <div class="stat-label" style="font-weight: 300; font-size: 1rem;">Pelanggan Puas</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Section -->
<!-- Menu Section -->
<section class="menu-section section" id="menu" style="background-color: #000; color: rgb(245, 245, 245); padding: 40px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div class="text-center" style="margin-bottom: 40px;">
            <h2 style="font-weight: 500; font-size: 2.5rem; margin-bottom: 20px; color: rgb(254, 198, 228);">Menu Favorit Kami</h2>
            <p style="font-weight: 300; font-size: 1.1rem; line-height: 1.6; margin-bottom: 0;">
                Pilihan roti terbaik yang dibuat fresh setiap hari dengan bahan-bahan berkualitas premium
            </p>
        </div>

        <div class="product-grid" style="display: flex; flex-wrap: nowrap; gap: 40px; justify-content: center; overflow-x: auto; padding-bottom: 20px;">
            @foreach($menus->take(4) as $menu)
                <a href="{{ route('menus.show', $menu->id) }}" class="product-card" style="
                    position: relative;
                    flex: 1 1 280px;
                    max-width: 280px;
                    aspect-ratio: 4 / 5;
                    border-radius: 8px;
                    overflow: hidden;
                    text-decoration: none;
                    color: rgb(245, 245, 245);
                    transition: transform 0.3s ease;
                    background-color: transparent;
                    display: flex;
                    flex-direction: column;
                " onmouseover="this.style.transform='translateY(-5px)';" onmouseout="this.style.transform='translateY(0)'">
                    @php
                        $images = $menu->images ? json_decode($menu->images) : null;
                        $firstImage = is_array($images) && count($images) > 0 ? $images[0] : ($menu->image ?? null);
                        $hasMultipleImages = is_array($images) && count($images) > 1;
                    @endphp
                    
                    @if($hasMultipleImages)
                        <div class="card-image-container" data-total-images="{{ count($images) }}" style="position: relative; width: 100%; height: 100%; flex-grow: 1; overflow: hidden;">
                            @foreach($images as $index => $imagePath)
                                <img 
                                    class="{{ $index === 0 ? 'primary-image' : 'gallery-image' }}" 
                                    src="{{ asset('storage/'.$imagePath) }}" 
                                    alt="{{ $menu->name }} - view {{ $index + 1 }}"
                                    data-index="{{ $index }}"
                                    style="
                                        width: 100%; 
                                        height: 100%; 
                                        object-fit: cover; 
                                        display: block; 
                                        position: {{ $index > 0 ? 'absolute' : 'relative' }}; 
                                        top: 0; 
                                        left: 0; 
                                        opacity: {{ $index === 0 ? '1' : '0' }};
                                        transition: opacity 0.5s ease;
                                    "
                                >
                            @endforeach
                        </div>
                    @elseif($firstImage)
                        <img src="{{ asset('storage/'.$firstImage) }}" alt="{{ $menu->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block; flex-grow: 1;">
                    @else
                        <img src="https://via.placeholder.com/280x350?text=No+Image" alt="No image" style="width: 100%; height: 100%; object-fit: cover; display: block; flex-grow: 1;">
                    @endif

                    <div style="
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        padding: 16px;
                        background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent);
                        color: rgb(245, 245, 245);
                        font-size: 0.9rem;
                        border-bottom-left-radius: 8px;
                        border-bottom-right-radius: 8px;
                        display: flex;
                        flex-direction: column;
                        justify-content: flex-end;
                        min-height: 50%;
                    ">
                        <!-- Nama produk full width -->
                        <h3 style="margin: 0 0 8px 0; font-weight: 500; font-size: 1.2rem; color: rgb(254, 198, 228);">
                            {{ $menu->name }}
                        </h3>

                        <!-- Kiri kanan baris 1: kategori & harga -->
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <div style="flex: 1; font-weight: 400; font-size: 0.9rem; color: rgb(220, 220, 220);">
                                {{ $menu->kategori }}
                            </div>
                            <div style="flex: 1; text-align: right; font-weight: 600; font-size: 1rem;">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Deskripsi full width -->
                        <p style="margin: 0 0 8px 0; font-weight: 300; font-size: 0.85rem; line-height: 1.3; font-style: italic; color: rgb(200, 200, 200); max-height: 3.6em; overflow: hidden; text-overflow: ellipsis;">
                            {{ $menu->description }}
                        </p>

                        <!-- Kiri kanan baris 2: rating & stok -->
                        <div style="display: flex; justify-content: space-between; align-items: center; color: rgb(254, 198, 228); font-weight: 600;">
                            <div style="display: flex; align-items: center;">
                                <span style="margin-right: 4px;">★</span>
                                <span style="color: rgb(245, 245, 245);">
                                    {{ $menu->reviews->count() > 0 ? number_format($menu->reviews->avg('rating'), 1) : '0.0' }}
                                </span>
                                <span style="color: rgb(180, 180, 180); font-size: 0.8rem; margin-left: 4px;">
                                    ({{ $menu->reviews->count() }})
                                </span>
                            </div>
                            <span style="color: rgb(200, 200, 200); font-weight: 400;">
                                {{ $menu->stok }} tersedia
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('menus.index') }}" class="btn btn-primary" style="
                display: inline-block;
                background-color: rgb(254, 198, 228);
                color: #000;
                padding: 12px 25px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: 600;
                transition: background-color 0.3s ease;
            ">
                Lihat Semua Menu
            </a>
        </div>
    </div>
</section>









<!-- <section class="why-choose-section section" style="background-color: #000; color: rgb(245, 245, 245); padding: 60px 20px;">
  <div class="container" style="max-width: 1200px; margin: 0 auto; text-align: center;">
    <h2 style="font-weight: 600; font-size: 2.8rem; margin-bottom: 10px; color: rgb(254, 198, 228);">Mengapa Memilih Kami?</h2>
    <p style="font-weight: 300; font-size: 1.2rem; line-height: 1.7; max-width: 700px; margin: 0 auto 50px; color: rgb(210, 210, 210);">
      Kami hadir dengan keunggulan yang membuat setiap roti kami istimewa dan berbeda. Temukan alasan mengapa pelanggan setia memilih kami sebagai toko roti favorit mereka.
    </p>

    <div class="features-horizontal" style="display: flex; justify-content: space-around; gap: 40px; flex-wrap: wrap;">
      <div class="feature-item" style="flex: 1 1 200px; max-width: 250px; cursor: default; transition: transform 0.3s ease;">
        <div style="
          width: 90px;
          height: 90px;
          margin: 0 auto 20px;
          background: rgb(254, 198, 228);
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 3.5rem;
          color: #000;
          user-select: none;
          transition: background-color 0.3s ease;
        ">
          🥖
        </div>
        <h3 style="font-weight: 600; font-size: 1.4rem; color: rgb(254, 198, 228); margin-bottom: 10px;">Bahan Premium</h3>
        <p style="font-weight: 300; font-size: 1rem; line-height: 1.6; color: rgb(210, 210, 210); margin: 0;">
          Kami hanya menggunakan bahan-bahan pilihan terbaik yang menjamin kualitas dan cita rasa roti yang tak tertandingi.
        </p>
      </div>

      <div class="feature-item" style="flex: 1 1 200px; max-width: 250px; cursor: default; transition: transform 0.3s ease;">
        <div style="
          width: 90px;
          height: 90px;
          margin: 0 auto 20px;
          background: rgb(254, 198, 228);
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 3.5rem;
          color: #000;
          user-select: none;
          transition: background-color 0.3s ease;
        ">
          🔥
        </div>
        <h3 style="font-weight: 600; font-size: 1.4rem; color: rgb(254, 198, 228); margin-bottom: 10px;">Roti Segar Setiap Hari</h3>
        <p style="font-weight: 300; font-size: 1rem; line-height: 1.6; color: rgb(210, 210, 210); margin: 0;">
          Setiap hari, roti kami dipanggang dengan penuh cinta dan kesegaran yang terjaga untuk Anda nikmati.
        </p>
      </div>

      <div class="feature-item" style="flex: 1 1 200px; max-width: 250px; cursor: default; transition: transform 0.3s ease;">
        <div style="
          width: 90px;
          height: 90px;
          margin: 0 auto 20px;
          background: rgb(254, 198, 228);
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 3.5rem;
          color: #000;
          user-select: none;
          transition: background-color 0.3s ease;
        ">
          💰
        </div>
        <h3 style="font-weight: 600; font-size: 1.4rem; color: rgb(254, 198, 228); margin-bottom: 10px;">Harga Terjangkau</h3>
        <p style="font-weight: 300; font-size: 1rem; line-height: 1.6; color: rgb(210, 210, 210); margin: 0;">
          Nikmati roti berkualitas premium dengan harga yang ramah di kantong, tanpa mengorbankan rasa dan kualitas.
        </p>
      </div>

      <div class="feature-item" style="flex: 1 1 200px; max-width: 250px; cursor: default; transition: transform 0.3s ease;">
        <div style="
          width: 90px;
          height: 90px;
          margin: 0 auto 20px;
          background: rgb(254, 198, 228);
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 3.5rem;
          color: #000;
          user-select: none;
          transition: background-color 0.3s ease;
        ">
          ⭐
        </div>
        <h3 style="font-weight: 600; font-size: 1.4rem; color: rgb(254, 198, 228); margin-bottom: 10px;">Pelayanan Terbaik</h3>
        <p style="font-weight: 300; font-size: 1rem; line-height: 1.6; color: rgb(210, 210, 210); margin: 0;">
          Tim kami siap melayani Anda dengan ramah dan profesional, memberikan pengalaman belanja yang menyenangkan.
        </p>
      </div>
    </div>

    <div style="margin-top: 50px;">
      <a href="#contact" style="
        display: inline-block;
        background-color: rgb(254, 198, 228);
        color: #000;
        padding: 14px 30px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(254, 198, 228, 0.6);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
      " onmouseover="this.style.backgroundColor='#fcb6d1'; this.style.boxShadow='0 6px 18px rgba(254, 198, 228, 0.9)';" onmouseout="this.style.backgroundColor='rgb(254, 198, 228)'; this.style.boxShadow='0 4px 12px rgba(254, 198, 228, 0.6)';">
        Hubungi Kami Sekarang
      </a>
    </div>
  </div>
</section> -->



<section style="background-color:#000; color:#f5f5f5; padding:40px 0;">
  <div style="max-width:1200px; margin:0 auto; padding:0 20px; text-align:center;">
    <h2 style="font-weight:500; font-size:2.5rem; color:#fec6e4; margin-bottom:30px;">Apa Kata Pelanggan Kami</h2>

    <div id="testimonial-carousel" style="display:flex; justify-content:center; gap:20px; max-width:1000px; margin:0 auto;">
      <!-- 5 kartu testimonial -->
      <div class="testimonial-card" style="flex: 0 0 220px; background:#000; border-radius:10px; padding:20px; box-sizing:border-box; opacity:0.4; transform: scale(0.9); transition: all 0.3s ease;">
        <img class="card-photo" src="" alt="" style="width:100%; border-radius:10px; object-fit:cover; margin-bottom:15px; height:150px;">
        <h3 class="card-name" style="color:#fec6e4; font-weight:400; font-size:1.3rem; margin:0 0 8px;"></h3>
        <p class="card-position" style="color:#d2d2d2; font-weight:300; font-size:1rem; margin:0 0 10px;"></p>
        <div class="card-rating" style="color:#fec6e4; font-size:1.1rem; margin-bottom:12px;"></div>
        <p class="card-desc" style="color:#e6e6e6; font-weight:300; font-size:1rem; line-height:1.5; margin:0;"></p>
      </div>
      <div class="testimonial-card" style="flex: 0 0 220px; background:#000; border-radius:10px; padding:20px; box-sizing:border-box; opacity:0.6; transform: scale(0.95); transition: all 0.3s ease;">
        <img class="card-photo" src="" alt="" style="width:100%; border-radius:10px; object-fit:cover; margin-bottom:15px; height:150px;">
        <h3 class="card-name" style="color:#fec6e4; font-weight:400; font-size:1.3rem; margin:0 0 8px;"></h3>
        <p class="card-position" style="color:#d2d2d2; font-weight:300; font-size:1rem; margin:0 0 10px;"></p>
        <div class="card-rating" style="color:#fec6e4; font-size:1.1rem; margin-bottom:12px;"></div>
        <p class="card-desc" style="color:#e6e6e6; font-weight:300; font-size:1rem; line-height:1.5; margin:0;"></p>
      </div>
      <div class="testimonial-card active" style="flex: 0 0 260px; background:#000; border-radius:10px; padding:25px; box-sizing:border-box; opacity:1; transform: scale(1); box-shadow: none; transition: all 0.3s ease;">
        <img class="card-photo" src="" alt="" style="width:100%; border-radius:10px; object-fit:cover; margin-bottom:20px; height:150px;">
        <h3 class="card-name" style="color:#fec6e4; font-weight:400; font-size:1.5rem; margin:0 0 10px;"></h3>
        <p class="card-position" style="color:#d2d2d2; font-weight:300; font-size:1.1rem; margin:0 0 12px;"></p>
        <div class="card-rating" style="color:#fec6e4; font-size:1.2rem; margin-bottom:15px;"></div>
        <p class="card-desc" style="color:#e6e6e6; font-weight:300; font-size:1.1rem; line-height:1.6; margin:0;"></p>
      </div>
      <div class="testimonial-card" style="flex: 0 0 220px; background:#000; border-radius:10px; padding:20px; box-sizing:border-box; opacity:0.6; transform: scale(0.95); transition: all 0.3s ease;">
        <img class="card-photo" src="" alt="" style="width:100%; border-radius:10px; object-fit:cover; margin-bottom:15px; height:150px;">
        <h3 class="card-name" style="color:#fec6e4; font-weight:400; font-size:1.3rem; margin:0 0 8px;"></h3>
        <p class="card-position" style="color:#d2d2d2; font-weight:300; font-size:1rem; margin:0 0 10px;"></p>
        <div class="card-rating" style="color:#fec6e4; font-size:1.1rem; margin-bottom:12px;"></div>
        <p class="card-desc" style="color:#e6e6e6; font-weight:300; font-size:1rem; line-height:1.5; margin:0;"></p>
      </div>
      <div class="testimonial-card" style="flex: 0 0 220px; background:#000; border-radius:10px; padding:20px; box-sizing:border-box; opacity:0.4; transform: scale(0.9); transition: all 0.3s ease;">
        <img class="card-photo" src="" alt="" style="width:100%; border-radius:10px; object-fit:cover; margin-bottom:15px; height:150px;">
        <h3 class="card-name" style="color:#fec6e4; font-weight:400; font-size:1.3rem; margin:0 0 8px;"></h3>
        <p class="card-position" style="color:#d2d2d2; font-weight:300; font-size:1rem; margin:0 0 10px;"></p>
        <div class="card-rating" style="color:#fec6e4; font-size:1.1rem; margin-bottom:12px;"></div>
        <p class="card-desc" style="color:#e6e6e6; font-weight:300; font-size:1rem; line-height:1.5; margin:0;"></p>
      </div>
    </div>

    <!-- Foto profil kecil bulat di bawah sebagai navigasi -->
    <div style="display:flex; justify-content:center; gap: 30px; margin-top: 40px;">
      <img class="profile-thumb" data-index="0" src="https://i.pravatar.cc/80?u=1" alt="Sari Andini" style="width:70px; height:70px; border-radius:50%; object-fit:cover; cursor:pointer; border: 2px solid transparent; transition: border-color 0.3s;">
      <img class="profile-thumb" data-index="1" src="https://i.pravatar.cc/80?u=2" alt="Budi Wijaya" style="width:70px; height:70px; border-radius:50%; object-fit:cover; cursor:pointer; border: 2px solid transparent; transition: border-color 0.3s;">
      <img class="profile-thumb" data-index="2" src="https://i.pravatar.cc/80?u=3" alt="Lisa Melati" style="width:70px; height:70px; border-radius:50%; object-fit:cover; cursor:pointer; border: 2px solid transparent; transition: border-color 0.3s;">
      <img class="profile-thumb" data-index="3" src="https://i.pravatar.cc/80?u=4" alt="Dewi Kartika" style="width:70px; height:70px; border-radius:50%; object-fit:cover; cursor:pointer; border: 2px solid transparent; transition: border-color 0.3s;">
      <img class="profile-thumb" data-index="4" src="https://i.pravatar.cc/80?u=5" alt="Rian Saputra" style="width:70px; height:70px; border-radius:50%; object-fit:cover; cursor:pointer; border: 2px solid transparent; transition: border-color 0.3s;">
    </div>
  </div>
</section>

<script>
  const testimonials = [
    {
      photo: "https://i.pravatar.cc/150?u=1",
      name: "Sari Andini",
      position: "Pelanggan Setia",
      rating: "★★★★☆",
      desc: "Rotinya selalu segar dan rasanya luar biasa! Sudah langganan di sini lebih dari 2 tahun dan tidak pernah kecewa."
    },
    {
      photo: "https://i.pravatar.cc/150?u=2",
      name: "Budi Wijaya",
      position: "Pelanggan Reguler",
      rating: "★★★★★",
      desc: "Pelayanannya ramah dan rotinya enak-enak. Harganya juga masih terjangkau. Recommended banget!"
    },
    {
      photo: "https://i.pravatar.cc/150?u=3",
      name: "Lisa Melati",
      position: "Pecinta Roti",
      rating: "★★★★☆",
      desc: "Roti coklat keju favoritku! Setiap pagi selalu beli di sini sebelum kerja. Mantap!"
    },
    {
      photo: "https://i.pravatar.cc/150?u=4",
      name: "Dewi Kartika",
      position: "Pelanggan Baru",
      rating: "★★★★★",
      desc: "Sangat puas dengan kualitas dan pelayanan."
    },
    {
      photo: "https://i.pravatar.cc/150?u=5",
      name: "Rian Saputra",
      position: "Pelanggan Lama",
      rating: "★★★★☆",
      desc: "Roti selalu fresh dan enak, recommended!"
    }
  ];

  const cards = document.querySelectorAll('#testimonial-carousel .testimonial-card');
  const thumbs = document.querySelectorAll('.profile-thumb');
  let currentIndex = 0;
  const total = testimonials.length;

  function updateCards(centerIndex) {
    for(let i=0; i<5; i++){
      let relativeIndex = (centerIndex - 2 + i + total) % total;
      let t = testimonials[relativeIndex];

      let card = cards[i];
      card.querySelector('.card-photo').src = t.photo;
      card.querySelector('.card-photo').alt = t.name;
      card.querySelector('.card-name').textContent = t.name;
      card.querySelector('.card-position').textContent = t.position;
      card.querySelector('.card-rating').textContent = t.rating;
      card.querySelector('.card-desc').textContent = t.desc;

      if(i === 2){
        card.style.opacity = '1';
        card.style.transform = 'scale(1)';
        card.style.backgroundColor = '#000';
        card.style.boxShadow = 'none';
        card.style.flexBasis = '260px';
        card.classList.add('active');
      } else if(i === 1 || i === 3){
        card.style.opacity = '0.6';
        card.style.transform = 'scale(0.95)';
        card.style.backgroundColor = '#000';
        card.style.boxShadow = 'none';
        card.style.flexBasis = '220px';
        card.classList.remove('active');
      } else {
        card.style.opacity = '0.4';
        card.style.transform = 'scale(0.9)';
        card.style.backgroundColor = '#000';
        card.style.boxShadow = 'none';
        card.style.flexBasis = '180px';
        card.classList.remove('active');
      }
    }

    thumbs.forEach((thumb, i) => {
      if(i === centerIndex){
        thumb.style.borderColor = '#fec6e4';
      } else {
        thumb.style.borderColor = 'transparent';
      }
    });
  }

  updateCards(currentIndex);

  thumbs.forEach(thumb => {
    thumb.addEventListener('click', () => {
      currentIndex = parseInt(thumb.dataset.index);
      updateCards(currentIndex);
      resetInterval();
    });
  });

  let interval = setInterval(() => {
    currentIndex = (currentIndex + 1) % total;
    updateCards(currentIndex);
  }, 5000);

  function resetInterval() {
    clearInterval(interval);
    interval = setInterval(() => {
      currentIndex = (currentIndex + 1) % total;
      updateCards(currentIndex);
    }, 5000);
  }
</script>













<section id="contact" style="background-color:#000; color:#f5f5f5; padding:50px 20px; font-family: Arial, sans-serif;">
  <div class="container" style="max-width:1200px; margin:0 auto; display:flex; flex-wrap: wrap; gap:40px;">

    <!-- Kiri -->
    <div style="flex:1 1 400px; min-width:280px; display:flex; flex-direction: column; gap:30px;">

      <!-- Judul & Deskripsi -->
      <div>
        <h2 style="color:#fec6e4; font-weight:700; font-size:2.5rem; margin-bottom:12px;">Get in Touch</h2>
        <p style="font-weight:300; font-size:1.1rem; line-height:1.6; color:#ccc;">
          Kami siap membantu Anda. Jangan ragu untuk menghubungi kami melalui informasi di bawah ini atau kirim pesan langsung.
        </p>
      </div>

      <!-- List kontak vertikal -->
      <div style="display:flex; flex-direction: column; gap:20px;">

        <!-- Item 1 -->
        <div style="display:flex; align-items:center; gap:15px;">
          <div style="background:#fec6e4; border-radius:8px; padding:10px; display:flex; align-items:center; justify-content:center; width:48px; height:48px;">
            <!-- Icon phone SVG pink -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000" viewBox="0 0 24 24"><path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.21 11.36 11.36 0 003.54 1.13 1 1 0 01.89 1v3.5a1 1 0 01-1 1A17 17 0 013 6a1 1 0 011-1h3.5a1 1 0 011 .89 11.36 11.36 0 001.13 3.54 1 1 0 01-.21 1.11l-2.2 2.2z"/></svg>
          </div>
          <div>
            <div style="font-weight:600; font-size:1.1rem; color:#f5f5f5;">Whatsapp</div>
            <div style="font-weight:400; font-size:1rem; color:#ccc;">+62 812 3456 7890</div>
          </div>
        </div>

        <!-- Item 2 -->
        <div style="display:flex; align-items:center; gap:15px;">
          <div style="background:#fec6e4; border-radius:8px; padding:10px; display:flex; align-items:center; justify-content:center; width:48px; height:48px;">
            <!-- Icon location SVG pink -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 3.87 7 13 7 13s7-9.13 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1114.5 9 2.5 2.5 0 0112 11.5z"/></svg>
          </div>
          <div>
            <div style="font-weight:600; font-size:1.1rem; color:#f5f5f5;">Alamat</div>
            <div style="font-weight:400; font-size:1rem; color:#ccc;">Jl. Raya Yogyakarta No. 123<br>Melati, Yogyakarta</div>
          </div>
        </div>

        <!-- Item 3 -->
        <div style="display:flex; align-items:center; gap:15px;">
          <div style="background:#fec6e4; border-radius:8px; padding:10px; display:flex; align-items:center; justify-content:center; width:48px; height:48px;">
            <!-- Icon email SVG pink -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000" viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 2v.01L12 13 4 6.01V6h16zM4 18v-9l8 6 8-6v9H4z"/></svg>
          </div>
          <div>
            <div style="font-weight:600; font-size:1.1rem; color:#f5f5f5;">Email</div>
            <div style="font-weight:400; font-size:1rem; color:#ccc;">info@tokoroti.com</div>
          </div>
        </div>

        <!-- Item 4 -->
        <div style="display:flex; align-items:center; gap:15px;">
          <div style="background:#fec6e4; border-radius:8px; padding:10px; display:flex; align-items:center; justify-content:center; width:48px; height:48px;">
            <!-- Icon clock SVG pink -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm0 16H5V8h14z"/></svg>
          </div>
          <div>
            <div style="font-weight:600; font-size:1.1rem; color:#f5f5f5;">Jam Operasional</div>
            <div style="font-weight:400; font-size:1rem; color:#ccc;">Senin - Minggu: 06:00 - 21:00</div>
          </div>
        </div>

      </div>
    </div>

    <!-- Kanan: Form minimalis -->
    <!-- Kanan: Form minimalis -->
<div style="flex:1 1 450px; min-width:320px; background:#000; padding:25px; border-radius:10px; box-sizing:border-box;">
  <h3 style="color:#fec6e4; font-weight:600; font-size:1.8rem; margin-bottom:20px;">Kirim Pesan</h3>
  <form style="display:flex; flex-direction: column; gap:15px;">
    <input type="text" placeholder="Nama Anda" required style="padding:10px 15px; border-radius:6px; border:none; background:#0d0c0e; color:#ffffff; font-size:1rem; outline:none;">
    <input type="email" placeholder="Email Anda" required style="padding:10px 15px; border-radius:6px; border:none; background:#0d0c0e; color:#ffffff; font-size:1rem; outline:none;">
    <textarea rows="4" placeholder="Tulis pesan Anda..." required style="padding:10px 15px; border-radius:6px; border:none; background:#0d0c0e; color:#ffffff; font-size:1rem; resize:none; outline:none;"></textarea>

    <button type="submit" style="background:#fec6e4; color:#000; padding:12px 20px; border:none; border-radius:6px; font-weight:700; font-size:1.1rem; cursor:pointer; transition: background-color 0.3s ease;">Kirim</button>
  </form>
</div>


  </div>

  <!-- Peta full width di bawah -->
  <div style="max-width:1200px; margin:40px auto 0; border-radius:10px; overflow:hidden; height:350px; box-shadow: 0 0 15px rgba(254,198,228,0.3);">
    <!-- OpenStreetMap embed -->
    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
      src="https://www.openstreetmap.org/export/embed.html?bbox=110.3605%2C-7.8005%2C110.3705%2C-7.7905&amp;layer=mapnik"
      style="border:0"></iframe>
  </div>

  <style>
    /* Placeholder abu sangat tua, tanpa glow dan outline */
    input::placeholder,
    textarea::placeholder {
      color: #222;
      font-style: italic;
    }
    input::-webkit-input-placeholder,
    textarea::-webkit-input-placeholder {
      color: #222;
      font-style: italic;
    }
    input:-moz-placeholder,
    textarea:-moz-placeholder {
      color: #222;
      font-style: italic;
    }
    input:-ms-input-placeholder,
    textarea:-ms-input-placeholder {
      color: #222;
      font-style: italic;
    }
    /* Hilangkan outline saat fokus */
    input:focus,
    textarea:focus {
      outline: none;
      border-color: #fec6e4;
      box-shadow: 0 0 5px #fec6e4;
    }
  </style>
</section>














<script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Form submission handlers
    document.querySelector('.contact-form form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Terima kasih! Pesan Anda telah dikirim.');
    });

    document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Terima kasih! Anda telah berlangganan newsletter kami.');
    });

    // Animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all sections
    document.querySelectorAll('.section').forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
    
    // Setup image rotation for product cards
    function setupCardImageRotation() {
        const cards = document.querySelectorAll('.product-card');
        
        cards.forEach(card => {
            const container = card.querySelector('.card-image-container');
            // Skip cards without image container (those with only one image)
            if (!container) return;
            
            const images = Array.from(container.querySelectorAll('img'));
            // Skip if there aren't at least 2 images
            if (images.length < 2) return;
            
            let currentIndex = 0;
            let interval;
            
            // Start automatic rotation when mouse enters the image container
            const imageContainer = card.querySelector('.card-image-container');
            if (imageContainer) {
                imageContainer.addEventListener('mouseenter', () => {
                    // Clear any existing interval
                    clearInterval(interval);
                    
                    // Always set up automatic rotation for multiple images
                    interval = setInterval(() => {
                        // Hide all images
                        images.forEach(img => {
                            img.style.opacity = 0;
                            img.style.transition = "opacity 0.5s ease";
                        });
                        
                        // Increment index and loop back if needed
                        currentIndex = (currentIndex + 1) % images.length;
                        
                        // Show next image
                        images[currentIndex].style.opacity = 1;
                    }, 1500); // Change image every 1.5 seconds
                    
                    // Immediately show the second image on hover with smooth transition
                    images[0].style.opacity = 0;
                    images[0].style.transition = "opacity 0.5s ease";
                    
                    setTimeout(() => {
                        images[1].style.opacity = 1;
                        images[1].style.transition = "opacity 0.5s ease";
                    }, 100);
                    
                    currentIndex = 1;
                });
                
                // Stop rotation when mouse leaves
                imageContainer.addEventListener('mouseleave', () => {
                    clearInterval(interval);
                    
                    // Reset to first image with smooth transition
                    images.forEach((img, index) => {
                        if (index === 0) {
                            setTimeout(() => {
                                img.style.opacity = 1;
                                img.style.transition = "opacity 0.5s ease";
                            }, 100);
                        } else {
                            img.style.opacity = 0;
                            img.style.transition = "opacity 0.5s ease";
                        }
                    });
                    currentIndex = 0;
                });
            }
        });
    }
    
    // Initialize image rotation
    document.addEventListener('DOMContentLoaded', function() {
        setupCardImageRotation();
    });
</script>

@endsection