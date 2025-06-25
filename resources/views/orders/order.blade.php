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
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 24px;
        padding: 30px;
        max-width: 1800px;
        margin: 0 auto;
    }

    @media (max-width: 1600px) {
        .product-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 1200px) {
        .product-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 900px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }

    .card {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        width: 300px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .card-image {
        width: 100%;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
        margin-bottom: 12px;
        color: #2c3e50;
    }

    .card-info {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 8px 12px;
        margin-bottom: 15px;
    }

    .card-info-label {
        font-weight: bold;
        color: #2c3e50;
    }

    .card-info-value {
        color: #34495e;
    }

    .product-list {
        margin: 5px 0;
        padding-left: 20px;
        max-height: 100px;
        overflow-y: auto;
    }

    .product-list li {
        margin-bottom: 4px;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        margin-top: 10px;
    }

    .btn-sm {
        font-size: 14px;
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
        text-decoration: none;
        text-align: center;
    }

    .btn-warning {
        background-color: #f1c40f;
        color: #2c3e50;
    }

    .btn-warning:hover {
        background-color: #f39c12;
    }

    .btn-danger {
        background-color: #e74c3c;
        color: #fff;
    }

    .btn-danger:hover {
        background-color: #c0392b;
    }

    .btn-detail {
        background-color: #f1c40f;
        color: #2c3e50;
        padding: 6px 15px;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
    }

    .btn-detail:hover {
        background-color: #f39c12;
    }

    .btn-reorder {
        background-color: #27ae60;
        color: white;
        padding: 6px 15px;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin-left: 8px;
    }

    .btn-reorder:hover {
        background-color: #229954;
    }

    .btn-review {
        background-color: #3498db;
        color: white;
        padding: 6px 15px;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin-left: 8px;
    }

    .btn-review:hover {
        background-color: #2980b9;
    }

    .alert {
        max-width: 700px;
        margin: 20px auto;
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
    }

    .status-badge, .payment-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
    }

    .status-pending {
        background-color: #f1c40f;
        color: #2c3e50;
    }

    .status-processing {
        background-color: #3498db;
        color: white;
    }

    .status-completed {
        background-color: #2ecc71;
        color: white;
    }

    .status-cancelled {
        background-color: #e74c3c;
        color: white;
    }

    .status-delivering {
        background-color: #9b59b6;
        color: white;
    }

    .status-unknown {
        background-color: #95a5a6;
        color: white;
    }

    .payment-success {
        background-color: #2ecc71;
        color: white;
    }

    .payment-failed {
        background-color: #e74c3c;
        color: white;
    }

    .payment-pending {
        background-color: #f1c40f;
        color: #2c3e50;
    }

    .payment-cancelled {
        background-color: #95a5a6;
        color: white;
    }

    .empty-state {
        text-align: center;
        margin-top: 40px;
        color: #7f8c8d;
    }

    .cart-animation {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 20px;
        border-radius: 10px;
        z-index: 9999;
        display: none;
        text-align: center;
    }

    .cart-icon {
        font-size: 48px;
        margin-bottom: 10px;
        animation: bounce 0.6s ease-in-out;
    }

    @keyframes bounce {
        0%, 20%, 60%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-20px);
        }
        80% {
            transform: translateY(-10px);
        }
    }
</style>

<div class="header-area">
    <h1>Daftar Pesanan</h1>
                    @if(auth()->check() && auth()->user()->is_admin)
        <a href="{{ route('menus.create') }}" class="btn-add">Tambah Produk</a>
@endif
                </div>

@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

@if($orders->count() > 0)
    <div class="product-grid">
        @foreach($orders as $order)
        <div class="card" onclick="window.location.href='{{ route('orders.show', $order->id) }}'">
            <div class="card-image">
                @php
                    // Coba ambil menu dari item pertama
                    $firstItem = $order->items->first();
                    $menu = $firstItem ? $firstItem->menu : null;
                    $menuImage = null;
                    
                    // Cek apakah menu memiliki images (JSON)
                    if ($menu && $menu->images) {
                        $images = json_decode($menu->images);
                        if (is_array($images) && count($images) > 0) {
                            $menuImage = $images[0]; // Ambil gambar pertama
                        }
                    }
                    // Fallback ke image jika images tidak ada
                    elseif ($menu && $menu->image) {
                        $menuImage = $menu->image;
                    }
                @endphp

                @if($menuImage)
                    <img src="{{ asset('storage/'.$menuImage) }}" alt="Gambar Pesanan"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/300x180?text=Pesanan'">
                @else
                    <img src="https://via.placeholder.com/300x180?text=Pesanan" alt="Gambar Pesanan">
                @endif
            </div>

            <div class="card-body">
                <div class="card-title">Kode: {{ $order->order_code ?? 'N/A' }}</div>

                <div class="card-info">
                    <div class="card-info-label">Total Harga:</div>
                    <div class="card-info-value">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</div>

                    <div class="card-info-label">Produk:</div>
                    <div class="card-info-value">
                        <ul class="product-list">
                            @forelse($order->items as $item)
                                <li>{{ $item->menu->name ?? 'Produk tidak tersedia' }} ({{ $item->quantity ?? 0 }}x)</li>
                            @empty
                                <li>Tidak ada produk</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="card-info-label">Status:</div>
                    <div class="card-info-value">
                        @php
                            $statusClass = 'status-unknown';
                            if($order->status == 'pending') $statusClass = 'status-pending';
                            elseif($order->status == 'processing') $statusClass = 'status-processing';
                            elseif($order->status == 'completed') $statusClass = 'status-completed';
                            elseif($order->status == 'cancelled') $statusClass = 'status-cancelled';
                            elseif($order->status == 'delivering') $statusClass = 'status-delivering';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ ucfirst($order->status ?? 'unknown') }}
                        </span>
                    </div>

                    <div class="card-info-label">Pembayaran:</div>
                    <div class="card-info-value">
                        @php
                            $paymentClass = 'payment-pending';
                            $paymentText = 'Pending';
                            
                            if($order->payment_status == 'success') {
                                $paymentClass = 'payment-success';
                                $paymentText = 'Berhasil';
                            } elseif($order->payment_status == 'failed') {
                                $paymentClass = 'payment-failed';
                                $paymentText = 'Gagal';
                            } elseif($order->payment_status == 'cancelled') {
                                $paymentClass = 'payment-cancelled';
                                $paymentText = 'Dibatalkan';
                            }
                        @endphp
                        <span class="payment-badge {{ $paymentClass }}">
                            {{ $paymentText }}
                        </span>
                    </div>

                    <div class="card-info-label">Tanggal:</div>
                    <div class="card-info-value">{{ $order->created_at ? $order->created_at->format('d M Y H:i') : 'N/A' }}</div>
                </div>

                @if($order->payment_status == 'success')
                <div style="text-align: center; margin-top: 5px;">
                    @if(!auth()->user()->is_admin)
                        @php
                            // Ambil menu_id dari item pertama
                            $firstItem = $order->items->first();
                            $menuId = $firstItem ? $firstItem->menu_id : null;
                        @endphp
                        @if($menuId)
                            <a href="{{ route('customer.reviews', ['menu_id' => $menuId]) }}" class="btn-review" onclick="event.stopPropagation()">Reviews</a>
                        @endif
                    @endif
                    <button onclick="event.stopPropagation(); reorderWithAnimation({{ $order->id }})" class="btn-reorder">Beli Lagi</button>
                </div>
                @endif

                @if(auth()->check() && auth()->user()->is_admin)
                <div class="btn-group" style="margin-top: 10px;">
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn-sm btn-warning" onclick="event.stopPropagation()">Edit</a>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus pesanan ini?')" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm btn-danger" onclick="event.stopPropagation()">Hapus</button>
                    </form>
                </div>
                @endif
            </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <p>Belum ada pesanan.</p>
        <a href="{{ route('menus.index') }}" class="btn-add">Mulai Belanja</a>
    </div>
@endif

<!-- Cart Animation Overlay -->
<div id="cartAnimation" class="cart-animation">
    <div class="cart-icon">🛒</div>
    <div>Menambahkan ke keranjang...</div>
</div>

<script>
function reorderWithAnimation(orderId) {
    // Show animation
    document.getElementById('cartAnimation').style.display = 'block';
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/orders/${orderId}/reorder`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    
    form.appendChild(csrfToken);
    document.body.appendChild(form);
    
    // Submit after animation delay
    setTimeout(() => {
        form.submit();
    }, 1500);
}
</script>

@endsection
