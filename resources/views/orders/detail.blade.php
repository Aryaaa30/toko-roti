@extends('layouts.app')

@section('content')
<style>
    /* --- Palet Warna & Variabel Tema Gelap --- */
    :root {
        --bg-dark: rgb(10, 10, 10);
        --card-bg: rgb(18, 18, 18);
        --border-color: rgb(40, 40, 40);
        
        /* Palet Warna Kustom */
        --text-base: rgb(245, 245, 245);
        --text-important: rgb(254, 198, 228); /* Pastel Pink */
        --text-secondary: #b0b0b0;
        --text-white: #ffffff;
        
        /* Warna Aksi & Status (dari tema gelap sebelumnya) */
        --color-success: #27ae60;
        --color-danger: #e74c3c;
        --color-warning: #f39c12;
        --color-info: #3498db;
        --color-grey: #95a5a6;
    }

    /* --- Reset & Gaya Global --- */
    body {
        background-color: var(--bg-dark);
        color: var(--text-base);
        font-family: 'Inter', sans-serif;
    }

    .detail-container {
        max-width: 1100px;
        margin: 2rem auto;
        padding: 2rem;
    }

    /* --- Header Halaman --- */
    .page-header {
        margin-bottom: 2rem;
    }
    .page-header h1 {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--text-base);
        margin: 0;
    }
    .page-header p {
        font-size: 1rem;
        color: var(--text-secondary);
        margin-top: 0.5rem;
    }

    /* --- Bar Informasi Pesanan --- */
    .order-info-bar {
        display: flex;
        justify-content: space-between;
        background-color: var(--card-bg);
        padding: 20px 30px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        margin-bottom: 2.5rem;
    }
    .info-item {
        text-align: left;
    }
    .info-item .label {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 5px;
    }
    .info-item .value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-base);
    }

    /* --- Grid Utama (Produk & Ringkasan) --- */
    .order-main-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2.5rem;
        align-items: flex-start;
    }

    /* --- Daftar Produk (Kolom Kiri) --- */
    .product-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .product-item {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }
    .product-list .product-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
        background-color: var(--border-color);
    }
    .product-info {
        flex: 1;
    }
    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-base);
    }
    .product-details {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-top: 5px;
    }
    .product-price {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-base);
    }

    /* --- Ringkasan Pembayaran (Kolom Kanan) --- */
    .order-summary {
        background-color: var(--card-bg);
        padding: 25px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        position: sticky;
        top: 2rem;
    }
    .summary-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-base);
        margin-bottom: 20px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 1rem;
        margin-bottom: 15px;
    }
    .summary-row .label {
        color: var(--text-secondary);
    }
    .summary-row .value {
        color: var(--text-base);
        font-weight: 500;
    }
    .summary-total {
        border-top: 1px solid var(--border-color);
        margin-top: 20px;
        padding-top: 20px;
    }
    .summary-total .label {
        font-size: 1.1rem;
        font-weight: bold;
    }
    .summary-total .value {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--text-important);
    }
    
    /* --- Aksi Admin & Elemen Lain --- */
    .admin-actions {
        margin-top: 2.5rem;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        padding: 25px;
        border-radius: 12px;
    }
    .btn-group { display: flex; gap: 10px; flex-wrap: wrap; }
    .btn { padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; transition: all 0.3s ease; }
    .btn-success { background-color: var(--color-success); color: white; }
    .btn-danger { background-color: var(--color-danger); color: white; }
    .btn-secondary { background-color: var(--color-grey); color: white; }
    .btn-success:hover, .btn-danger:hover, .btn-secondary:hover { opacity: 0.85; }

    /* --- Responsive --- */
    @media (max-width: 992px) {
        .order-main-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 768px) {
        .order-info-bar {
            flex-direction: column;
            gap: 1.5rem;
            align-items: flex-start;
        }
        .product-item {
            flex-direction: column;
            align-items: flex-start;
        }
        .product-price {
            margin-top: 10px;
        }
    }
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-sA+e2tu6p+U6GkG6lLrj5lZQ+1Q9Q4p1gXkG4QmQf3s=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-o9N1jRVv6Gk6GkG6lLrj5lZQ+1Q9Q4p1gXkG4QmQf3s=" crossorigin=""></script>

<div class="detail-container">

    @php
        // Logika untuk status dan pembayaran agar template lebih bersih
        $statusMap = [
            'pending' => ['text' => 'Pending'],
            'processing' => ['text' => 'Diproses'],
            'completed' => ['text' => 'Selesai (Confirmed)'],
            'cancelled' => ['text' => 'Dibatalkan'],
            'delivering' => ['text' => 'Dikirim'],
        ];
        $statusInfo = $statusMap[$order->status] ?? ['text' => ucfirst($order->status)];

        $paymentMap = [
            'success' => 'Pembayaran Berhasil',
            'failed' => 'Pembayaran Gagal',
            'cancelled' => 'Pembayaran Dibatalkan',
            'pending' => 'Menunggu Pembayaran',
        ];
        $paymentInfo = $paymentMap[$order->payment_status] ?? ucfirst($order->payment_status);
    @endphp

    <div class="page-header">
        <h1>Detail Pesanan Anda</h1>
        <p>Halo, {{ $order->user->name ?? 'Pelanggan' }}. Terima kasih, pesanan Anda telah {{ strtolower($statusInfo['text']) }}.</p>
    </div>

    <div class="order-info-bar">
        <div class="info-item">
            <div class="label">Tanggal Pesanan</div>
            <div class="value">{{ $order->created_at->format('d M Y') }}</div>
        </div>
        <div class="info-item">
            <div class="label">Order ID</div>
            <div class="value">#{{ $order->order_code }}</div>
        </div>
        <div class="info-item">
            <div class="label">Status Pembayaran</div>
            <div class="value">{{ $paymentInfo }}</div>
        </div>
    </div>

    <div class="order-main-grid">
        <div class="product-list-section">
            <div class="product-list">
                @forelse($order->items as $item)
                    <div class="product-item">
                        @php
                            $menu = $item->menu;
                            $menuImage = $menu && $menu->images ? (json_decode($menu->images)[0] ?? null) : ($menu->image ?? null);
                        @endphp
                        <img src="{{ $menuImage ? asset('storage/'.$menuImage) : 'https://via.placeholder.com/80x80?text=N/A' }}" 
                             alt="{{ $menu->name ?? '' }}" class="product-image"
                             onerror="this.src='https://via.placeholder.com/80x80?text=N/A'">
                        
                        <div class="product-info">
                            <div class="product-name">{{ $menu->name ?? 'Produk tidak tersedia' }}</div>
                            <div class="product-description" style="font-size: 0.85rem; color: var(--text-secondary); margin: 5px 0;">
                                {{ $menu->description ?? 'Tidak ada deskripsi' }}
                            </div>
                            <div class="product-details">Jumlah: {{ $item->quantity }}</div>
                        </div>

                        <div class="product-price">
                            Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <p>Tidak ada item dalam pesanan ini.</p>
                @endforelse
            </div>
        </div>

        <div class="order-summary-section">
            <div class="order-summary">
                <h2 class="summary-title">Rincian Pembayaran</h2>
                
                {{-- Diadaptasi karena data hanya memiliki total akhir --}}
                <div class="summary-row">
                    <div class="label">Subtotal</div>
                    <div class="value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                </div>
                 <div class="summary-row">
                    <div class="label">Biaya Pengiriman</div>
                    <div class="value">Rp 0</div>
                </div>
                 <div class="summary-row">
                    <div class="label">Pajak</div>
                    <div class="value">Rp 0</div>
                </div>

                <div class="summary-row summary-total">
                    <div class="label">Total</div>
                    <div class="value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->is_admin)
    <div class="admin-actions">
        <h2 class="summary-title">Aksi Admin - Konfirmasi Pembayaran</h2>
        <div class="btn-group">
            @if($order->payment_status == 'pending')
                <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="payment_status" value="success">
                    <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi pembayaran berhasil?')">✓ Berhasil</button>
                </form>
                <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="payment_status" value="failed">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tandai pembayaran gagal?')">✗ Gagal</button>
                </form>
                <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="payment_status" value="cancelled">
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Batalkan pembayaran?')">⊘ Batalkan</button>
                </form>
            @else
                <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="payment_status" value="pending">
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Reset status ke pending?')">↻ Reset ke Pending</button>
                </form>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection