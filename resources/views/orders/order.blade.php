@php
    use Illuminate\Support\Facades\Storage;
@endphp

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
        justify-content: center;
        gap: 24px;
        padding: 30px;
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

    .payment-paid {
        background-color: #2ecc71;
        color: white;
    }

    .payment-unpaid {
        background-color: #e74c3c;
        color: white;
    }

    .payment-pending {
        background-color: #f1c40f;
        color: #2c3e50;
    }

    .empty-state {
        text-align: center;
        margin-top: 40px;
        color: #7f8c8d;
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
        <div class="card">
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
                            $paymentClass = 'payment-unpaid';
                            if($order->payment_status == 'paid') $paymentClass = 'payment-paid';
                            elseif($order->payment_status == 'pending') $paymentClass = 'payment-pending';
                        @endphp
                        <span class="payment-badge {{ $paymentClass }}">
                            {{ ucfirst($order->payment_status ?? 'unpaid') }}
                        </span>
                    </div>

                    <div class="card-info-label">Tanggal:</div>
                    <div class="card-info-value">{{ $order->created_at ? $order->created_at->format('d M Y H:i') : 'N/A' }}</div>
                </div>

                <div style="text-align: center; margin-top: 5px;">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn-detail">Detail</a>

                    @if(auth()->check() && auth()->user()->is_admin)
                    <div class="btn-group" style="margin-top: 10px;">
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn-sm btn-warning">Edit</a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-sm btn-danger">Hapus</button>
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
