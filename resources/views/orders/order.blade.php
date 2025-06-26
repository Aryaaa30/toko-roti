@extends('layouts.app')

@section('content')
<style>
    /* --- Color & Theme Variables (TIDAK DIUBAH) --- */
    :root {
        --bg-dark: rgb(10, 10, 10);
        --card-bg: rgb(18, 18, 18);
        --border-color: rgb(40, 40, 40);
        
        /* Custom Color Palette */
        --text-base: rgb(245, 245, 245);
        --text-important: rgb(254, 198, 228); /* Pastel Pink */
        --text-secondary: #b0b0b0;
        --text-white: #ffffff;
        
        /* Action & Status Colors */
        --color-success: rgb(254, 198, 228);  /* Hijau untuk delivered/completed */
        --color-warning: #f1c40f;  /* Kuning untuk processed/pending */
        --color-info: #3498db;
        --color-danger: #e74c3c;
    }

    /* --- General Resets & Dark Theme --- */
    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-dark);
        color: var(--text-base);
    }

    /* --- Main Layout: Sidebar + Content --- */
    .account-container {
        display: flex;
        gap: 40px;
        max-width: 1600px;
        margin: 2rem auto;
        padding: 0 2rem;
        align-items: flex-start;
    }

    /* --- Sidebar Styling (Tidak Diubah) --- */
    .sidebar {
      background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 40px;
    flex: 0 0 340px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: sticky;
    top: 2rem;
  }
    
    .sidebar-header h2 { font-size: 24px; font-weight: 700; color: var(--text-important); line-height: 1.2; }
    .sidebar-header p { font-size: 14px; color: var(--text-secondary); margin-bottom: 2.5rem; }
    .sidebar-nav { display: flex; flex-direction: column; gap: 1.2rem; }
    .sidebar-nav a { color: var(--text-secondary); text-decoration: none; font-weight: 500; font-size: 16px; padding: 8px 15px; border-radius: 8px; border-left: 3px solid transparent; transition: all 0.3s ease; }
    .sidebar-nav a:hover { background-color: rgba(255, 255, 255, 0.05); color: var(--text-white); }
    .sidebar-nav a.active { background-color: rgba(254, 198, 228, 0.1); color: var(--text-important); font-weight: 700; border-left: 3px solid var(--text-important); }
    .sidebar-footer { margin-top: 3rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); }
    .sidebar-footer button { background: none; border: none; color: var(--text-secondary); cursor: pointer; font-size: 16px; font-weight: 500; padding: 8px 15px; width: 100%; text-align: left; font-family: 'Inter', sans-serif; }
    .sidebar-footer button:hover { color: var(--color-danger); }

    /* --- Main Content (Konten Utama) --- */
    .main-content { flex: 1; padding-left: 7.5rem ;padding-right: 9rem;}
    .main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .main-header h1 { font-size: 32px; color: var(--text-base); margin-bottom: 0; }

    /* --- NEW LAYOUT: Order List --- */
    .order-list-container {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .order-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .order-info-group {
        display: flex;
        gap: 40px;
        flex-wrap: wrap;
        align-items: center;
    }

    .info-item .label {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 4px;
    }
    .info-item .value {
        font-weight: 600;
        color: var(--text-base);
    }
    
    .status-badge {
        font-weight: 600;
        text-transform: capitalize;
    }
    .status-processing { color: var(--color-warning); }
    .status-completed, .status-delivering { color: var(--color-success); }
    .status-pending { color: var(--color-warning); }
    .status-cancelled { color: var(--color-danger); }

    .order-actions .btn {
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-primary {
        background-color: var(--text-important);
        color: var(--bg-dark);
    }
    .btn-primary:hover {
        opacity: 0.85;
    }
    
    /* --- Daftar Item Produk --- */
    .order-items-list {
        padding: 25px;
        border-top: 1px solid var(--border-color);
    }

    /* --- PERBAIKAN PADA PRODUCT ITEM --- */
    .product-item {
        display: flex;
        align-items: flex-start; /* Mengubah ke flex-start agar tidak terpusat vertikal */
        gap: 20px;
        not(:last-child) {
            margin-bottom: 25px;
        }
    }
    .product-image {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        object-fit: cover;
        background-color: var(--border-color);
        flex-shrink: 0;
    }
    .product-info {
        flex-grow: 1; /* Membuat bagian ini memanjang dan mendorong bagian kanan */
    }
    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-base);
        margin-bottom: 8px;
    }
    .product-details {
        font-size: 0.9rem;
        color: var(--text-secondary);
        line-height: 1.5;
    }
    
    .product-actions-price {
        display: flex;
        flex-direction: column;
        align-items: flex-end; /* Membuat konten (harga & tombol) rata kanan */
        flex-shrink: 0; /* Mencegah bagian ini menyusut */
    }
    .product-price {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-base);
        margin-bottom: 12px; /* Jarak antara harga dan tombol 'Beli Lagi' */
    }
    .product-buy-again button {
        color: var(--text-important);
        text-decoration: none;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    /* State Kosong */
    .empty-state { text-align: center; margin-top: 50px; color: var(--text-secondary); background: var(--card-bg); padding: 50px; border-radius: 12px; border: 1px dashed var(--border-color); }
    .empty-state p { font-size: 18px; margin-bottom: 25px; }
    .btn-add { background-color: var(--text-important); color: var(--bg-dark); padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; transition: background-color 0.3s ease; }
    .btn-add:hover { opacity: 0.85; }

</style>

<div class="account-container">
    

    {{-- Main Content (Order List) --}}
    <main class="main-content" role="main">
        <div class="main-header">
            <h1>Riwayat Pesanan Anda</h1>
        </div>

        @if($orders->count() > 0)
            <div class="order-list-container">
                @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info-group">
                            <div class="info-item">
                                <div class="label">Order Number</div>
                                <div class="value">#{{ $order->order_code }}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Order Date</div>
                                <div class="value">{{ $order->created_at->format('d M, Y') }}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Total Amount</div>
                                <div class="value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                            </div>
                            <div class="info-item">
                                <div class="label">Status</div>
                                @php
                                    $statusClass = '';
                                    if ($order->status == 'processing') $statusClass = 'status-processing';
                                    elseif ($order->status == 'completed') $statusClass = 'status-completed';
                                    elseif ($order->status == 'delivering') $statusClass = 'status-delivering';
                                    elseif ($order->status == 'cancelled') $statusClass = 'status-cancelled';
                                    else $statusClass = 'status-pending';
                                @endphp
                                <div class="value"><span class="status-badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span></div>
                            </div>
                        </div>
                        <div class="order-actions">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">View Order</a>
                        </div>
                    </div>
                    <div class="order-items-list">
                        @foreach($order->items as $item)
                        @php
                            $menu = $item->menu;
                            $menuImage = $menu && $menu->images ? (json_decode($menu->images)[0] ?? null) : ($menu->image ?? null);
                        @endphp
                        <div class="product-item mb-5">
                            <img src="{{ $menuImage ? asset('storage/'.$menuImage) : 'https://via.placeholder.com/100x100?text=N/A' }}" 
                                 alt="{{ $menu->name ?? 'Produk' }}" class="product-image"
                                 onerror="this.src='https://via.placeholder.com/100x100?text=N/A'">
                            
                            {{-- BAGIAN KIRI: Informasi Produk --}}
                            <div class="product-info">
                                <div class="product-name">{{ $menu->name ?? 'Produk Tidak Tersedia' }}</div>
                                <div class="product-description" style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 5px;">
                                    {{ $menu->description ?? 'Tidak ada deskripsi' }}
                                </div>
                                <div class="product-details">
                                   Jumlah: {{ $item->quantity }}
                                </div>
                            </div>

                            {{-- BAGIAN KANAN: Harga dan Tombol Aksi --}}
                            <div class="product-actions-price">
                                <div class="product-price">
                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                </div>
                                <div class="product-buy-again">
                                     <button onclick="event.stopPropagation(); reorderWithAnimation({{ $order->id }})">Beli Lagi</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <p>Anda belum memiliki riwayat pesanan.</p>
                <a href="{{ route('menus.index') }}" class="btn-add">Mulai Belanja Sekarang</a>
            </div>
        @endif
    </main>
</div>

{{-- Script ini tetap diperlukan untuk fungsi "Beli Lagi" --}}
<div id="cartAnimation" class="cart-animation" style="display: none;">
    <div class="cart-icon">🛒</div>
    <div>Menambahkan ke keranjang...</div>
</div>

<script>
function reorderWithAnimation(orderId) {
    event.preventDefault(); 
    document.getElementById('cartAnimation').style.display = 'block';
    
    const form = document.createElement('form');
    form.method = 'POST';
    // Pastikan route reorder ini ada di web.php Anda
    form.action = `/orders/${orderId}/reorder`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    
    form.appendChild(csrfToken);
    document.body.appendChild(form);
    
    setTimeout(() => {
        form.submit();
    }, 1500);
}
</script>

@endsection