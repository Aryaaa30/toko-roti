@extends('layouts.app')

@section('content')
<style>
    .detail-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .detail-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f1f1;
    }

    .detail-header h1 {
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .order-code {
        font-size: 18px;
        font-weight: bold;
        color: #3498db;
    }

    .detail-section {
        margin-bottom: 25px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 15px;
        border-bottom: 2px solid #3498db;
        padding-bottom: 5px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 10px;
        margin-bottom: 15px;
    }

    .info-label {
        font-weight: bold;
        color: #2c3e50;
    }

    .info-value {
        color: #34495e;
    }

    .product-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background: white;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        margin-right: 15px;
        object-fit: cover;
    }

    .product-info {
        flex: 1;
    }

    .product-name {
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .product-details {
        color: #7f8c8d;
        font-size: 14px;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .payment-pending {
        background-color: #f39c12;
        color: white;
    }

    .payment-success {
        background-color: #27ae60;
        color: white;
    }

    .payment-failed {
        background-color: #e74c3c;
        color: white;
    }

    .payment-cancelled {
        background-color: #95a5a6;
        color: white;
    }

    .status-pending {
        background-color: #f39c12;
        color: white;
    }

    .status-processing {
        background-color: #3498db;
        color: white;
    }

    .status-completed {
        background-color: #27ae60;
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

    .admin-actions {
        background: #ecf0f1;
        padding: 20px;
        border-radius: 8px;
        margin-top: 20px;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-success {
        background-color: #27ae60;
        color: white;
    }

    .btn-success:hover {
        background-color: #229954;
    }

    .btn-danger {
        background-color: #e74c3c;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c0392b;
    }

    .btn-secondary {
        background-color: #95a5a6;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #7f8c8d;
    }

    .btn-back {
        background-color: #3498db;
        color: white;
        margin-bottom: 20px;
    }

    .btn-back:hover {
        background-color: #2980b9;
    }

    .total-section {
        background: #2c3e50;
        color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }

    .total-amount {
        font-size: 24px;
        font-weight: bold;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-weight: bold;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<div class="detail-container">
    <a href="{{ route('orders.index') }}" class="btn btn-back">← Kembali ke Daftar Pesanan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="detail-header">
        <h1>Detail Pesanan</h1>
        <div class="order-code">{{ $order->order_code }}</div>
    </div>

    <!-- Informasi Pesanan -->
    <div class="detail-section">
        <div class="section-title">Informasi Pesanan</div>
        <div class="info-grid">
            <div class="info-label">Tanggal Pesanan:</div>
            <div class="info-value">{{ $order->created_at->format('d F Y, H:i') }}</div>

            <div class="info-label">Status Pesanan:</div>
            <div class="info-value">
                @php
                    $statusClass = 'status-unknown';
                    if($order->status == 'pending') $statusClass = 'status-pending';
                    elseif($order->status == 'processing') $statusClass = 'status-processing';
                    elseif($order->status == 'completed') $statusClass = 'status-completed';
                    elseif($order->status == 'cancelled') $statusClass = 'status-cancelled';
                @endphp
                <span class="status-badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
            </div>

            <div class="info-label">Status Pembayaran:</div>
            <div class="info-value">
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
                <span class="status-badge {{ $paymentClass }}">{{ $paymentText }}</span>
            </div>

            <div class="info-label">Nama Pemesan:</div>
            <div class="info-value">{{ $order->user->name ?? 'N/A' }}</div>

            <div class="info-label">Email:</div>
            <div class="info-value">{{ $order->user->email ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="detail-section">
        <div class="section-title">Produk yang Dipesan</div>
        @foreach($order->items as $item)
        <div class="product-item">
            @php
                $menu = $item->menu;
                $menuImage = null;
                
                if ($menu && $menu->images) {
                    $images = json_decode($menu->images);
                    if (is_array($images) && count($images) > 0) {
                        $menuImage = $images[0];
                    }
                } elseif ($menu && $menu->image) {
                    $menuImage = $menu->image;
                }
            @endphp

            @if($menuImage)
                <img src="{{ asset('storage/'.$menuImage) }}" alt="{{ $menu->name }}" class="product-image"
                     onerror="this.src='https://via.placeholder.com/80x80?text=Produk'">
            @else
                <img src="https://via.placeholder.com/80x80?text=Produk" alt="Produk" class="product-image">
            @endif

            <div class="product-info">
                <div class="product-name">{{ $menu->name ?? 'Produk tidak tersedia' }}</div>
                <div class="product-details">
                    Jumlah: {{ $item->quantity }}x | 
                    Harga: Rp {{ number_format($item->price, 0, ',', '.') }} | 
                    Subtotal: Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Total Pembayaran -->
    <div class="total-section">
        <div>Total Pembayaran</div>
        <div class="total-amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
    </div>

    <!-- Admin Actions -->
    @if(auth()->check() && auth()->user()->is_admin)
    <div class="admin-actions">
        <div class="section-title">Aksi Admin - Konfirmasi Pembayaran</div>
        <div class="btn-group">
            @if($order->payment_status == 'pending')
                <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="payment_status" value="success">
                    <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi pembayaran berhasil?')">
                        ✓ Konfirmasi Berhasil
                    </button>
                </form>

                <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="payment_status" value="failed">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tandai pembayaran gagal?')">
                        ✗ Tandai Gagal
                    </button>
                </form>

                <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="payment_status" value="cancelled">
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Batalkan pembayaran?')">
                        ⊘ Batalkan
                    </button>
                </form>
            @else
                <form action="{{ route('orders.updatePayment', $order->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="payment_status" value="pending">
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Reset status ke pending?')">
                        ↻ Reset ke Pending
                    </button>
                </form>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection